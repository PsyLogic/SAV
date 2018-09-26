<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commercial;

class CommercialController extends Controller
{

    public function __construct()
    {   
//        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return response()->json(Commercial::all());
        }
        return view('commercial.index', ['commercials' => Commercial::all()]);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( $request->ajax() ){
            $this->validate($request, [
                'full_name' => 'required|max:100',
                'phone' => 'required',
                'belong_to' => 'required',
            ]);
            
            $commcercial = Commercial::create($request->all());
            return response()->json($commcercial);
        }
        
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if( $request->ajax() ){
            $commcercial = Commercial::findorFail($id);
                return response()->json($commcercial);
        }
        abort(403);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if( $request->ajax() ){
            $this->validate($request, [
                'full_name' => 'required|max:100',
                'phone' => 'required',
                'belong_to' => 'required',
            ]);
            
            $commcercial = Commercial::findOrFail($id);
           
            $commcercial->full_name = $request->full_name;
            $commcercial->phone = $request->phone;
            $commcercial->belong_to = $request->belong_to;

            return response()->json($commcercial->saveOrFail());
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if( $request->ajax() ){
            return response()->json(Commercial::findOrFail($id)->delete());
        }
        abort(403);
    }
}
