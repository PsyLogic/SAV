<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Issue;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request){

        if($request->ajax()){
            
            // Total of requests
            $totalRequests = Issue::totalIssues();
    
            // Total of  Opened Requests
            $opened = Issue::totalOf('stage',1);
    
            // Total of  in Process Requests
            $process = Issue::totalOf('stage',2);
    
            // Total of  Closed Requests
            $closed = Issue::totalOf('stage',3);
    
            // Total of  Closed Requests
            $diagnostic = ["Software"=>Issue::totalOf('diagnostic',"software"),"Hardware"=>Issue::totalOf('diagnostic',"hardware")];

            // Total of  Closed Requests
            $models = Issue::select('client')->get();
            $models = $models->groupBy('client.model')->map(function($item,$key){
                return count($item);
            })->all();
        
            return response()->json(compact('totalRequests','opened','process','closed','models','diagnostic'));
        }
        
        return view('dashboard');

    }
}
