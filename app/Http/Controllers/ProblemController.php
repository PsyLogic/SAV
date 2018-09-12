<?php

namespace App\Http\Controllers;

use App\Problem;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return response()->json(Problem::all());
        }
        return view('problem.index',['problems' => Problem::all()]);
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
            $this->validate($request,[
                'content' => 'required',
                'eligibility' => 'required',
            ]);
            $problem = Problem::create($request->all());
            return response()->json($problem);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->ajax()){
            return response()->json(Problem::findOrFail($id));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()){
            
            $this->validate($request,[
                'content' => 'required',
                'eligibility' => 'required',
            ]);
            $problem = Problem::findOrFail($id);

            $problem->content = $request->content;
            $problem->eligibility = $request->eligibility;
            
            return response()->json($problem->saveOrFail());
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax()){
            return response()->json(Problem::findOrFail($id)->delete());
        }
        abort(403);
    }
}
