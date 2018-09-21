<?php

namespace App\Http\Controllers;

use App\Commercial;
use App\Image;
use App\Issue;
use App\Problem;
use App\Solution;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IssueController extends Controller
{
    /**
     * Display a listing of the issues.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $issues = Issue::with(['commercial:id,full_name', 'user:id,name'])->get();
        if ($request->ajax()) {
            // $issues = $issues->map(function($item){
            //     $item->stage = $item->stage($item->stage);
            //     return $item;
            // });
            return response()->json($issues->sortByDesc('delivered_at'));
        }
        return view('issue.index', ['issues' => $issues->sortByDesc('delivered_at'), 'problems' => Problem::all(), 'solutions' => Solution::all()]);
    }

    /**
     * Show the form for creating a new issue.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('issue.create', ['commercials' => Commercial::all()]);
    }

    /**
     * Store a newly created issue
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {

            $validate = Validator::make($request->all(), [
                'imei' => 'between:0:15',
                'commercial_id' => 'required',
            ]);

            $imei = $request->imei;

            // Check IMEI if exists before sumbit anything
            $client = $this->getClientInformation($imei);
            if (isset($client['error']) && $client['error'] === true) {
                return response()->json($client, 404);
            }

            $issue = Issue::create([
                'imei' => $imei,
                'commercial_id' => $request->commercial_id,
                'client' => $client,
            ]);

            return response()->json($issue);
        }

        abort(403);
    }

    /**
     * Display the specified issue.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $issue = Issue::findOrfail($id);
        return view('issue.details', compact('issue'));
    }

    /**
     * Update Issue to 2nd stage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            // Validate Request data
            $this->validate($request, [
                'imei' => 'required|between:15,15',
                'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imei = $request->imei;
            $images = $request->file('images');
            $today = Carbon::now();

            // Check IMEI if exists before sumbit anything
            $client = $this->getClientInformation($imei);
            if (isset($client['error']) && $client['error'] === true) {
                return response()->json($client, 404);
            }

            // Upload init Images of phone
            $path = $today->format('Y-m-d') . '/' . $imei;
            $errors = "";
            $uploadParams = ['images' => $images, 'path' => $path, 'issue_id' => $id, "status" => "before"];
            if ($request->hasFile('images')) {
                $errors = $this->uploadPhoto($uploadParams);
            } else {
                $errors = "No File is Uploaded";
            }

            if (!empty($errors) && !is_bool($errors)) {
                return response()->json(['message' => $errors], 412);
            }

            // update issue information
            $issue = Issue::findOrFail($id);
            $issue->imei = $imei;
            $issue->user_id = Auth::user()->id; // Assign this issue to Authenticated Agent
            $issue->received_at = $today; // The date of receiving the package and time of verifying it.
            $issue->stage = 2; // Going to stage 2 of the issue (in process)
            $issue->client = $client; // Update Client information
            $issue->saveOrFail();

            return response()->json(['message' => "The IMEI is verified and Images are uploaded successfully"], 200);
        }
        abort(403);
    }

    /**
     * Update the issue to 3rd stage (final stage).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function finalUpdate(Request $request, $id)
    {
        if ($request->ajax()) {

            $issue = Issue::findOrFail($id);
            $imei = $issue->imei;
            $diagnostic = $request->diagnostic;
            $images = $request->file('images');

            // Upload Images Information
            $today = Carbon::now();
            $path = $today->format('Y-m-d') . '/' . $imei;
            $errors = "";
            $uploadParams = ['images' => $images, 'path' => $path, 'issue_id' => $issue_id, "status" => "after"];

            if ($diagnostic == 'software') {
                $this->validate($request, [
                    'solution' => 'required',
                    'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
                ]);

                if ($request->hasFile('images')) {
                    $errors = $this->uploadPhoto($uploadParams);
                }

                if (!empty($errors) && !is_bool($errors)) {
                    return response()->json(['message' => $errors], 412);
                }

            } else {
                $this->validate($request, [
                    'solution' => 'required',
                    'problems' => 'required',
                    'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                ]);

                if ($request->hasFile('images')) {
                    $errors = $this->uploadPhoto($uploadParams);
                } else {
                    $errors = "No File is Uploaded";
                }

                if (!empty($errors) && !is_bool($errors)) {
                    return response()->json(['message' => $errors], 412);
                }

                // update issue information
                $issue->charges = $request->charges; // Fees of repair.
            }

            // update issue information
            $issue->diagnostic = $diagnostic; // The diagnostic if issue ( software).
            $issue->closed_at = $today; // The date of closing the issue.
            $issue->stage = 3; // Going to stage 3 of the issue (Closed)
            $issue->saveOrFail();

            // Check if solution is selected or an other solution is defined
            if (!empty($request->extra_solution)) {
                $solution = Solution::create([
                    'content' => $request->extra_solution,
                ]);

                $solution = Solution::find($solution->id);
                $issue->solutions()->attach($solution);
            }

            $solutions = Solution::find($request->solution);
            $issue->solutions()->attach($solutions);

            // Check if problem is selected or an other problem is defined
            if (!empty($request->extra_problem)) {
                $problem = Problem::create([
                    'content' => $request->extra_problem,
                    'eligibility' => $request->eligibility,
                ]);

                $problem = Problem::find($problem->id);
                $issue->problems()->attach($problem);
            }

            $problems = Problem::find($request->problems);
            $issue->problems()->attach($problems);

            return response()->json(['message' => "Thank you for your work, the issue is closed now"], 200);

        }
        abort(403);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get Images of Issue.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function images(Request $request)
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

    private function uploadPhoto(array $info)
    {

        $uploaded = true;
        $errors = "";
        foreach ($info['images'] as $image) {
            $storePath = $image->store($path);
            if ($storePath) {
                $newImage = new Image();
                $newImage->file_name = $storePath;
                $newImage->issue_id = $info['issue_id'];
                $newImage->status = $info['status'];
                $newImage->saveOrFail();
            } else {
                $uploaded = false;
                $errors += "Error Uploading File: " . $image->gertClientOriginalName()+"\n";
            }
        }

        if (!$uploaded) {
            return $errors;
        }

        return $uploaded;

    }
    private function getClientInformation($imei)
    {
        if (!empty($imei) && strlen($imei) == 15) {
            $result = $this->verifyIMEI($imei);
            if ($result['code'] == 404) {
                return ['message' => $result['content'], 'error' => true];
            }

            return $result['content'];
        }
    }

    private function verifyIMEI($imei)
    {
        $endpoint = "http://154.70.200.106:8004/api/getinfo";
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $endpoint, ['query' => [
            'imei' => $imei,
        ]]);

        $content = json_decode($response->getBody(), true);
        $statusCode = $content['status'];

        if ($statusCode == 200) {
            $registration_info = $content['data'][0]['registration'];
            $client_info = $content['data'][0]['registration']['client'];
            $content = [
                "date_flow" => $registration_info['data_flow'],
                "full_name" => $client_info['first_name'] . ' ' . $client_info['last_name'],
                "tel" => $client_info['tel'],
            ];
        } else {
            $content = $content['data'];
        }
        return ['code' => $statusCode, 'content' => $content];
    }
}
