<?php

namespace App\Http\Controllers;

use App\Solution;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return response()->json(Solution::all());
        }
        return view('solution.index',['solutions' => Solution::all()]);
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
            ]);
            $solution = Solution::create($request->all());
            return response()->json($solution);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->ajax()){
            return response()->json(Solution::findOrFail($id));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()){
            
            $this->validate($request,[
                'content' => 'required',
            ]);
            $solution = Solution::findOrFail($id);
            $solution->content = $request->content;
            return response()->json($solution->saveOrFail());
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax()){
            return response()->json(Solution::findOrFail($id)->delete());
        }
        abort(403);
    }

}
