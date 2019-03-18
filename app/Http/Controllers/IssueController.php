<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use App\Image;
use App\Issue;
use App\Problem;
use App\Solution;
use Carbon\Carbon;
use App\Commercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageHandler;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\IssueResource;

class IssueController extends Controller
{
    /**
     * Display a listing of the issues.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = Issue::with(['commercial','user:id,name'])->orderByDesc('delivered_at')->get();
        return view('issue.index', ['issues' => $issues, 'problems' => Problem::all(),'solutions' => Solution::all()]);
    }

    public function list(Request $request){
        // $issues = Issue::with(['commercial','user:id,name'])->orderByDesc('delivered_at')->get();
        if($request->ajax()){
            return IssueResource::collection(Issue::all());
            // return response()->json($issues);
        }
        return abort(403);
    }

    /**
     * Show the form for creating a new issue.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('issue.create',['commercials' => Commercial::all()]);
    }

    /**
     * Store a newly created issue
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            
            Validator::make($request->all(),[
                'imei' => 'between:0:15',
                'commercial_id' => 'required',
                'received_at' => 'required'
            ]);
            $imei = $request->imei;

            // Check IMEI if exists before sumbit anything
            $client = $this->getClientInformation($imei);
            if(isset($client['error']) && $client['error'] === true)
                return response()->json($client,404);

            $issue = Issue::create([
                'imei' => $imei,
                'commercial_id' => $request->commercial_id,
                'client' => $client,
                'received_at' => $request->received_at,
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
        return view('issue.details',compact('issue'));
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
        if($request->ajax()){

            // Validate Request data
            $this->validate($request,[
                'imei' => 'required|between:15,15',
                'images.*' => 'required|image|mimes:jpg,jpeg,png|max:6144'
            ]);
            
            $imei = $request->imei;
            $images = Input::file('images');
            $today = Carbon::now();

            // Check IMEI if exists before sumbit anything
            $client = $this->getClientInformation($imei);
            if(isset($client['error']) && $client['error'] === true)
                return response()->json($client,404);
           
            // Upload init Images of phone 
            $folder = $today->format('Y-m-d').'/'.$id.'/';
            $path = public_path('storage').'/'.$folder;
            $errors = "";
            
            if($request->hasFile('images')){
                foreach($images as $image){
                    $fileName = time().'.'.$image->getClientOriginalExtension();
                    $fullPath = $path.$fileName;
                    $this->checkDirectory($fullPath);
                    $saved = ImageHandler::make($image)
                    ->resize(600, 500)
                    ->save($fullPath);
                    if($saved){
                        $newImage = new Image();
                        $newImage->file_name = $folder.$fileName;
                        $newImage->issue_id = $id;
                        $newImage->status = "before";

                        $newImage->saveOrFail();
                    }else{
                        $errors += "Error Uploading File: " . $image->gertClientOriginalName() + "\n";
                    }
                }
            }else{
                $errors = "No File is Uploaded";
            }

            if(!empty($errors)){
                return response()->json(['message' => $errors],412);
            }
            
            // update issue information
            $issue = Issue::findOrFail($id);
            $issue->imei = $imei;
            $issue->user_id = Auth::user()->id; // Assign this issue to Authenticated Agent
            $issue->received_at = $today; // The date of receiving the package and time of verifying it.
            $issue->stage = 2; // Going to stage 2 of the issue (in process)
            $issue->client = $client; // Update Client information
            $issue->saveOrFail();
            
            return response()->json(['message' => "The IMEI is verified and Images are uploaded successfully"],200);
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
        if($request->ajax()){

            $issue = Issue::findOrFail($id);
            $diagnostic = $request->diagnostic;
            $images = Input::file('images');
            $errors = "";
            

            if($request->imei_stage_3 == "999999999999999" || empty($request->imei_stage_3)){
                $errors = "You must Fill the IMEI field with the real one";
                return response()->json(['message' => $errors],412);
            }

            $imei = $request->imei_stage_3;

            if($diagnostic == 'software'){
                $this->validate($request,[
                    'solution' => 'required',
                    'images.*' => 'image|mimes:jpg,jpeg,png|max:6144'
                ]);

                

                // Upload init Images of phone 
                $today = Carbon::now();
                $folder = $today->format('Y-m-d').'/'.$id.'/';
                $path = public_path('storage').'/'.$folder;

                if($request->hasFile('images')){

                    foreach($images as $image){
                        $fileName = time().'.'.$image->getClientOriginalExtension();
                        $fullPath = $path.$fileName;
                        $this->checkDirectory($fullPath);
                        $saved = ImageHandler::make($image)
                        ->resize(600, 500)
                        ->save($fullPath);
                        if($saved){
                            $newImage = new Image();
                            $newImage->file_name = $folder.$fileName;
                            $newImage->issue_id = $id;
                            $newImage->status = "after";
    
                            $newImage->saveOrFail();
                        }else{
                            $errors += "Error Uploading File: " . $image->gertClientOriginalName() + "\n";
                        }
                    }

                }
                
                if(!empty($errors)){
                    return response()->json(['message' => $errors],412);
                }
                
                // Check if solution is selected or an other solution is defined
                
                if(!empty($request->extra_solution)){
                    $solution = Solution::create([
                            'content' => $request->extra_solution,
                    ]);

                    $solution = Solution::find($solution->id);
                    $issue->solutions()->attach($solution);
                }

                $solutions = Solution::find($request->solution);
                $issue->solutions()->attach($solutions);

                // update issue information
                $issue->imei = $imei; // The diagnostic if issue ( software).
                $issue->diagnostic = $diagnostic; // The diagnostic if issue ( software).
                $issue->closed_at = $today; // The date of closing the issue.
                $issue->stage = 3; // Going to stage 3 of the issue (Closed)
                $issue->saveOrFail();
                
                return response()->json(['message' => "Thank you for your work, the issue is closed now"],200);

            }else{
                
                $this->validate($request,[
                    'solution' => 'required',
                    'images.*' => 'required|image|mimes:jpg,jpeg,png|max:6144',
                    'charges' => 'numeric'
                ]);

                // Upload init Images of phone 
                $today = Carbon::now();
                $folder = $today->format('Y-m-d').'/'.$id.'/';
                $path = public_path('storage').'/'.$folder;
                $errors = "";

                if($request->hasFile('images')){

                    foreach($images as $image){
                        $fileName = time().'.'.$image->getClientOriginalExtension();
                        $fullPath = $path.$fileName;
                        $this->checkDirectory($fullPath);
                        $saved = ImageHandler::make($image)
                        ->resize(600, 500)
                        ->save($fullPath);
                        if($saved){
                            $newImage = new Image();
                            $newImage->file_name = $folder.$fileName;
                            $newImage->issue_id = $id;
                            $newImage->status = "after";
    
                            $newImage->saveOrFail();
                        }else{
                            $errors += "Error Uploading File: " . $image->gertClientOriginalName() + "\n";
                        }
                    }

                }else{
                    $errors = "No File is Uploaded";
                }
                
                if(!empty($errors)){
                    return response()->json(['message' => $errors],412);
                }
                

                // update issue information
                $issue->imei = $imei; // The diagnostic if issue ( software).
                $issue->diagnostic = $diagnostic; // The diagnostic if issue ( software).
                $issue->charges = $request->charges; // Fees of repair.
                $issue->closed_at = $today; // The date of closing the issue.
                $issue->stage = 3; // Going to stage 3 of the issue (closed)
                $issue->saveOrFail();

                // Check if problem is selected or an other problem is defined

                if(!empty($request->extra_problem)){
                    $problem = Problem::create([
                            'content' => $request->extra_problem,
                            'eligibility' => $request->eligibility
                    ]);

                    $problem = Problem::find($problem->id);
                    $issue->problems()->attach($problem);
                }

                $problems = Problem::find($request->problems);
                $issue->problems()->attach($problems);


                if(!empty($request->extra_solution)){
                    $solution = Solution::create([
                            'content' => $request->extra_solution,
                    ]);

                    $solution = Solution::find($solution->id);
                    $issue->solutions()->attach($solution);
                }

                $solutions = Solution::find($request->solution);
                $issue->solutions()->attach($solutions);


                
                return response()->json(['message' => "Thank you for your work, the issue is closed now"],200);
            }

        }
        abort(403);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax()){
            $issue = Issue::findOrFail($id);
            return response()->json($issue->delete());
        }
        
        abort(403);
    }

    /**
     * Get Images of Issue.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function images(Request $request)
    {
        if($request->ajax()){
            
            $id = $request->id;
            $status = $request->status;
    
            $images = Image::where('issue_id',$id)
                            ->where('status',$status)
                            ->get();
            $images = $images->map(function($item){
                $item->file_name = $item->getImageUrl();
                return $item;
            });
            return response()->json($images);

        }

        abort(403);
    }


    /**
     * Get Report summary of an issue
     *
     * @param [integer] $id
     * @return void
     */
    public function report($id){
        
        $issue = Issue::findOrFail($id);
        return view('issue.report', compact('issue'));

        // view()->share('issue',$issue);
        // return route('issues.report',1);


        //  $pdf = PDF::loadView('issue.report');
        //  $pdf = PDF::loadView('issue.report', compact('issue'));
        //  $file_name = 'report-'. $issue->imei . '.pdf';
        //  return $pdf->download('report.pdf');

    }



    
    private function getClientInformation($imei){
        if(!empty($imei) && strlen($imei) == 15){
            $result = $this->verifyIMEI($imei);
            if( $result['code'] == 404 )
                return ['message' => $result['content'], 'error'=>true];
            
            return $result['content'];
        }
    }

    private function verifyIMEI($imei){
        $endpoint = "http://154.70.200.106:8003/api/getinfo";
        $client = new  \GuzzleHttp\Client();
        $options = [ 'query' => ['imei' => $imei] ];
        
        $response = $client->request('GET', $endpoint, $options);

        $content = json_decode($response->getBody(), true);
        $statusCode = $content['status']; 

        if($statusCode == 200){
            $phone_info = $content['data'][0];
            $registration_info = $content['data'][0]['registration'];
            $client_info = $content['data'][0]['registration']['client'];
            $content = [
                "imei2"     => $phone_info['imei2'],
                "model"     => $phone_info['model']['name'],
                "date_flow" => $registration_info['data_flow'],
                "full_name" => $client_info['first_name'] . ' ' . $client_info['last_name'],
                "address" => $client_info['address'] ?? '',
                "city" => $client_info['city'] ?? '',
                "tel" => $client_info['tel'] ?? '',
            ];
        }else{
            $content = $content['data'];
        }
        return ['code'=>$statusCode,'content'=>$content];
    }

    private function checkDirectory(string $path){
        $pathInfo = pathinfo($path); 
        if( !\File::exists( $pathInfo['dirname'] ) ) {
            \File::makeDirectory( $pathInfo['dirname'], 0755, true ); 
        }
    }
}
