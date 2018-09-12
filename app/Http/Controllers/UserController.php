<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return response()->json(User::all());
        }
        return view('user.index', ['users' => User::select('id','name','username')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all());
        $user = $this->create($request->all());
        return response()->json($user);
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
            return response()->json(User::findorFail($id));
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
                'name' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username,'.$id,
                'email' => 'string|email|max:255',
                'type' => 'required|string',
            ]);
            
            $user = User::find($id);
            
            if($user){
                $user->name = $request->name;
                $user->username = $request->username;
                $user->email = $request->email;
                $user->type = $request->type;
            }
            return response()->json($user->saveOrFail());
        }
        abort(403);
    }

    /**
     * Update User password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        if( $request->ajax() ){

            $this->validate($request, [
                'password' => 'required|string|min:6|confirmed'
            ]);
            
            $user = User::find($id);
            
            if($user){
                if($user->password == Hash::make($request['password'])){
                    return response()->json(['error'=> 'You type same old password']);        
                }else{
                    $user->password = Hash::make($request['password']);
                }
            }
            return response()->json($user->saveOrFail());
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
            return response()->json(User::findOrFail($id)->delete());
        }
        abort(403);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users|max:255',
            'email' => 'string|email|max:255',
            'type' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    private function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'type' => $data['type'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
