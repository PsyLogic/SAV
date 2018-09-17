<?php

namespace App\Http\Controllers;

use App\Issue;
use Illuminate\Http\Request;
use App\Commercial;
use Illuminate\Support\Facades\Validator;
use App\Image;
use Carbon\Carbon;
use Auth;
use App\Problem;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $issues = Issue::with(['commercial:id,full_name','user:id,name'])->get();
        if($request->ajax()){
            // $issues = $issues->map(function($item){
            //     $item->stage = $item->stage($item->stage);
            //     return $item;
            // });
            return response()->json($issues->sortByDesc('delivered_at'));
        }
        return view('issue.index', ['issues' => $issues->sortByDesc('delivered_at'), 'problems' => Problem::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('issue.create',['commercials' => Commercial::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            
            $validate = Validator::make($request->all(),[
                'imei' => 'between:0:15',
                'commercial_id' => 'required'
            ]);
            
            $imei = $request->imei;

            // Check IMEI if exists before sumbit anything
            $client = $this->getClientInformation($imei);
            if(isset($client['error']) && $client['error'] === true)
                return response()->json($client,404);

            $issue = Issue::create([
                'imei' => $imei,
                'commercial_id' => $request->commercial_id,
                'client' => $client
            ]);
                
                return response()->json($issue);
        }

        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return Issue::where('id',$id)->with(['commercial:id,full_name','user:id,name'])->get();
        $issue = Issue::findOrfail($id);//where('id',$id)->with(['commercial:id,full_name','user:id,name'])->get();
        return view('issue.details',compact('issue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()){
           
            // Validate Request data
            $this->validate($request,[
                'imei' => 'required|between:15,15',
                'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048'
            ]);
            
            $imei = $request->imei;
            $images = $request->file('images');
            $today = Carbon::now();

            // Check IMEI if exists before sumbit anything
            $client = $this->getClientInformation($imei);
            if(isset($client['error']) && $client['error'] === true)
                return response()->json($client,404);
           
            // Upload init Images of phone 
            $path = $today->format('Y-m-d').'/'.$imei;
            $errors = "";
            
            if($request->hasFile('images')){
                foreach($images as $image){
                    $storePath = $image->store($path);
                    if($storePath){
                        $newImage = new Image();
                        $newImage->file_name = $storePath;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function finalUpdate(Request $request, $id)
    {
        if($request->ajax()){
            // return $request->all();
            $issue = Issue::findOrFail($id);
            $imei = $issue->imei;
            $diagnostic = $request->diagnostic;
            $images = $request->file('images');
            if($diagnostic == 'software'){
                $this->validate($request,[
                    'solution' => 'required',
                    'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
                ]);

                // Upload init Images of phone 
                $today = Carbon::now();
                $path = $today->format('Y-m-d').'/'.$imei;
                $errors = "";

                if($request->hasFile('images')){

                    foreach($images as $image){
                        $storePath = $image->store($path);
                        if($storePath){
                            $newImage = new Image();
                            $newImage->file_name = $storePath;
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
                
                // update issue information

                $issue->diagnostic = $diagnostic; // The diagnostic if issue ( software).
                $issue->extra_problem = $request->extra_problem ; // extra problems of the issue
                $issue->solution = $request->solution ; // The solution of the issue.
                $issue->closed_at = $today; // The date of closing the issue.
                $issue->stage = 3; // Going to stage 3 of the issue (Closed)
                $issue->saveOrFail();
                
                return response()->json(['message' => "Thank you for your work, the issue is closed now"],200);

            }else{
                
                $this->validate($request,[
                    'solution' => 'required',
                    'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048'
                ]);

                // Upload init Images of phone 
                $today = Carbon::now();
                $path = $today->format('Y-m-d').'/'.$imei;
                $errors = "";

                if($request->hasFile('images')){

                    foreach($images as $image){
                        $storePath = $image->store($path);
                        if($storePath){
                            $newImage = new Image();
                            $newImage->file_name = $storePath;
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
                $issue->diagnostic = $diagnostic; // The diagnostic if issue ( software).
                $issue->extra_problem = $request->extra_problem ; // extra problems of the issue
                $issue->solution = $request->solution; // The solution of the issue.
                $issue->charges = $request->charges; // Fees of repair.
                $issue->closed_at = $today; // The date of closing the issue.
                $issue->stage = 3; // Going to stage 3 of the issue (closed)
                $issue->saveOrFail();

                // Check if problem is selected or an other problem is defined
                $problem_id = $request->problems[0];
                if($problem_id < 0){
                    $problem = Problem::create([
                            'content' => $request->other_problem_content,
                            'eligibility' => $request->eligibility
                    ]);

                    $problem = Problem::find($problem->id);
                    $issue->problems()->attach($problem);
                }

                $problems = Problem::find($request->problems);
                $issue->problems()->attach($problems);
                
                return response()->json(['message' => "Thank you for your work, the issue is closed now"],200);
            }

        }
        abort(403);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get Images of Issue.
     *
     * @param  \App\Issue  $issue
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



    
    private function getClientInformation($imei){
        if(!empty($imei) && strlen($imei) == 15){
            $result = $this->verifyIMEI($imei);
            if( $result['code'] == 404 )
                return ['message' => $result['content'], 'error'=>true];
            
            return $result['content'];
        }
    }

    private function verifyIMEI($imei){
        $endpoint = "http://154.70.200.106:8004/api/getinfo";
        $client = new  \GuzzleHttp\Client();
        
        $response = $client->request('GET', $endpoint, ['query' => [
            'imei' => $imei,
        ]]);

        $content = json_decode($response->getBody(), true);
        $statusCode = $content['status']; 

        if($statusCode == 200){
            $registration_info = $content['data'][0]['registration'];
            $client_info = $content['data'][0]['registration']['client'];
            $content = [
                "date_flow" => $registration_info['data_flow'],
                "full_name" => $client_info['first_name'] . ' ' . $client_info['last_name'],
                "tel" => $client_info['tel'],
            ];
        }else{
            $content = $content['data'];
        }
        return ['code'=>$statusCode,'content'=>$content];
    }
}
