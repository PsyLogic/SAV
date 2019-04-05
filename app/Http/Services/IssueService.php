<?php

namespace App\Http\Services;

use Auth;
use App\Http\Requests\Issue\{StoreIssueRequest,UpdateIssueRequest,FinalUpdateIssueRequest};
use App\Http\Requests\Issue\{FetchClientRequest,UpdateClientRequest};
use App\{Image,Issue,Problem,Solution};
use App\Http\Resources\IssueResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{File,Input,DB};
use Illuminate\Database\QueryException;
use Intervention\Image\Facades\Image as ImageHandler;
use GuzzleHttp\Client;
use Carbon\Carbon;

class IssueService
{

    public function home() {
        $issues = Issue::with(['commercial','user:id,name'])->orderByDesc('delivered_at')->get();
        return ['issues' => $issues, 'problems' => Problem::all(),'solutions' => Solution::all()];
    }

    public function getList(Request $request)
    {
        return $request->ajax() ? IssueResource::collection(Issue::all()) : abort(403);
    }

    public function add(StoreIssueRequest $requestData)
    {

        if ($requestData->ajax()) {

            // Check IMEI if exists before sumbit anything
            $client = $this->getClientInformation($requestData->imei);

            if (isset($client['error']) && $client['error'] === true) return response()->json($client, 404);

            Issue::create([
                'imei' => $requestData->imei,
                'commercial_id' => $requestData->commercial_id,
                'client' => $client,
                'received_at' => $requestData->received_at,
            ]);
            return response()->json('done');
        }
        abort(403);
    }

    public function update(UpdateIssueRequest $requestData, Issue $issue)
    {

        if ($requestData->ajax()) {

            $imei = $requestData->imei;

            // Check IMEI if exists before sumbit anything
            $client = $this->getClientInformation($imei);

            if (isset($client['error']) && $client['error'] === true) return response()->json($client, 404);

            if ($requestData->hasFile('images'))
                $this->uploadPhoneImage($issue->id, Input::file('images'));
            else 
                $errors = "No File is Uploaded";

            if (!empty($errors)) return response()->json(['message' => $errors], 412);

            // update issue information
            $issue->imei = $imei;
            $issue->user_id = Auth::user()->id; // Assign this issue to Authenticated Agent
            $issue->received_at = Carbon::now(); // The date of receiving the package and time of verifying it.
            $issue->stage = 2; // Going to stage 2 of the issue (in process)
            $issue->client = $client; // Update Client information
            $issue->saveOrFail();

            return response()->json(['message' => "The IMEI is verified and Images are uploaded successfully"], 200);
        }
        abort(403);
    }

    public function finalUpdate(FinalUpdateIssueRequest $requestData, Issue $issue)
    {
        if ($requestData->ajax()) {

            $diagnostic = $requestData->diagnostic;
            $imei = $requestData->imei_stage_3;
            $images = Input::file('images');
            $errors = "";

            if ($imei === '999999999999999') 
                return response()->json(['message' => "You must Fill the IMEI field with the real one"], 412);

             // Check IMEI if exists before sumbit anything
             $client = $this->getClientInformation($imei);
             if (isset($client['error']) && $client['error'] === true) return response()->json($client, 404);

            if ($diagnostic == 'software') {

                if ($requestData->hasFile('images')) $this->uploadPhoneImage($issue->id, $images, 'after');
                
            } else {
                $requestData->hasFile('images') ? $this->uploadPhoneImage($issue->id, $images, 'after') : $errors = "No File is Uploaded";

                if (!empty($errors)) return response()->json(['message' => $errors], 412);

                // Check if problem is selected or an other problem is defined
                if (!empty($requestData->extra_problem)) {
                    $problem = Problem::create([
                        'content' => $requestData->extra_problem,
                        'eligibility' => $requestData->eligibility,
                    ]);

                    $problem = Problem::find($problem->id);
                    $issue->problems()->attach($problem);
                }

                $problems = Problem::find($requestData->problems);
                $issue->problems()->attach($problems);

                $issue->charges = $requestData->charges; // Fees of repair.
            }
            // update issue information
            $issue->imei = $imei; // The diagnostic if issue ( software).
            $issue->diagnostic = $diagnostic; // The diagnostic if issue ( software).
            $issue->closed_at = Carbon::now(); // The date of closing the issue.
            $issue->stage = 3; // Going to stage 3 of the issue (closed)
            $issue->client = $client; // update client info
            $issue->saveOrFail();

            // Check if solution is selected or an other solution is defined
            if (!empty($requestData->extra_solution)) {
                $solution = Solution::create([
                    'content' => $requestData->extra_solution,
                ]);

                $solution = Solution::find($solution->id);
                $issue->solutions()->attach($solution);
            }

            $solutions = Solution::find($requestData->solution);
            $issue->solutions()->attach($solutions);

            return response()->json(['message' => "Thank you for your work, the issue is closed now"], 200);
        }
        abort(403);
    }

    public function getImages(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $status = $request->status;

            $images = Image::where('issue_id', $id)
                ->where('status', $status)
                ->get();
            $images = $images->map(function ($item) {
                $item->file_name = $item->getImageUrl();
                return $item;
            });
            return response()->json($images);
        }

        abort(403);
    }

    public function getClientBy(FetchClientRequest $request){
        if($request->ajax()){
            $imei = $request->imei;
            if($imei == '999999999999999')
                return response()->json('Please enter a valid IMEI',422);
            return Issue::select('client')->where('imei',$imei)->first()->client ?? response()->json('IMEI not found',404);
        }
        return view('issue.modify');
    }
    
    public function updateClientInfo(UpdateClientRequest $request, $imei){
        try {
            return DB::table('issues')
            ->where('imei', $imei)
            ->update([
                'client->full_name' => $request->full_name,
                'client->tel' => $request->phone,
                'client->city' => $request->city,
            ]);
        }catch (QueryException $e) {
            return response()->json($e->getMessage(),500);
        } catch (\PDOException $e) {
            return response()->json($e->getMessage(),500);
        } 
    }

    private function getClientInformation($imei)
    {
        $result = $this->verifyIMEI($imei);
        return ($result['code'] !== 404) ? $result['content'] : ['message' => $result['content'], 'error' => true];
    }

    private function checkDirectory($path)
    {
        $pathInfo = pathinfo($path);
        if (!FILE::exists($pathInfo['dirname'])) File::makeDirectory($pathInfo['dirname'], 0755, true);
    }

    // TODO: this function needs to processed in the queue
    private function uploadPhoneImage($issue_id, $images, $status = 'before')
    {
        $today = Carbon::now();
        $folder = $today->format('Y-m-d') . '/' . $issue_id . '/';
        $path = public_path('storage') . '/' . $folder;
        $errors = [];

        foreach ($images as $image) {
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $fullPath = $path . $fileName;
            $this->checkDirectory($fullPath);
            $saved = ImageHandler::make($image)
                ->resize(600, 500)
                ->save($fullPath);
            if ($saved) {
                $newImage = new Image;
                $newImage->file_name = $folder . $fileName;
                $newImage->issue_id = $issue_id;
                $newImage->status = $status;

                $newImage->saveOrFail();
            } else {
                $errors += "Error Uploading File: " . $image->gertClientOriginalName()+"\n";
            }
        }

        if (!empty($errors)) {
            return response()->json(['message' => $errors], 412);
        }

        return true;
    }

    private function verifyIMEI($imei)
    {
        $endpoint = "http://154.70.200.106:8003/api/getinfo";
        $client = new Client;
        $options = ['query' => ['imei' => $imei]];

        $response = $client->request('GET', $endpoint, $options);

        $content = json_decode($response->getBody(), true);
        $statusCode = $content['status'];

        if ($statusCode == 200) {
            $phone_info = $content['data'][0];
            $registration_info = $content['data'][0]['registration'];
            $client_info = $content['data'][0]['registration']['client'];
            $content = [
                "imei2" => $phone_info['imei2'],
                "model" => $phone_info['model']['name'],
                "date_flow" => $registration_info['data_flow'],
                "full_name" => $client_info['first_name'] . ' ' . $client_info['last_name'],
                "address" => $client_info['address'] ?? '',
                "city" => $client_info['city'] ?? '',
                "tel" => $client_info['tel'] ?? '',
            ];
        } else {
            $content = $content['data'];
        }
        return ['code' => $statusCode, 'content' => $content];
    }
}
