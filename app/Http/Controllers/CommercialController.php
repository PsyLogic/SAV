<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commercial;

class CommercialController extends Controller
{
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
        return view('commercial.index');
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
            ]);
            
            $commcercial = Commercial::create($request->all());
            return response()->json($commcercial);
        }
        return response()->json("Nothing is here");
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
        return response()->json("Nothing is here"); 
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
            ]);
            
            $commcercial = Commercial::find($id);
            if($commcercial){
                $commcercial->full_name = $request->full_name;
                $commcercial->phone = $request->phone;
            }
            return response()->json($commcercial->saveOrFail());
        }
        return response()->json("Nothing is here");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(Commercial::findOrFail($id)->delete());
    }
}
