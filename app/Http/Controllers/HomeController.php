<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Issue;
use DB;

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
    public function __invoke(){
        return view('dashboard');
    }

    public function getStatistics(){
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

    public function problemsByModel($model){
        if($model!='none'){
            $eligibility = 1;
            $problems =  DB::select('select p.content, count(p.id) as countp
                                from issues i, problems p, issue_problem ip 
                                where i.id = ip.issue_id and p.id = ip.problem_id and JSON_EXTRACT(client, "$.model") = ? and p.eligibility = ?
                                group by p.content order by countp desc',
                            [$model,$eligibility]);
            
            return response()->json($problems);
        }
        return response()->json(array());

    }
}
