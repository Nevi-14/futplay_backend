<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
  
        $validator = $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'photo'=>'',
            'avatar'=>'',
            'status'=>'',
            'google_sign_in'=>'',
            'email'=>'required | unique',
            'email_verified_at'=>'required',
            'password'=>'required'
        ]);
        if($validator){
      $user =      User::create([
                'name'=>$request->name,
            ]);
            return response()->json([
                'message'=>'El usuario se creo con éxito.',
                'user'=>$user
            ]);
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'user'=>$request
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function getUsers(){

        $users = User::all();
        

        return response()->json([
            'users'=>$users,
        ]);
    }

    public function login($email){

        $user = User::get()->where('email', $email)->first();
    
        return response()->json([
            'user'=>$user,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteUser($email)
    {
        $user = User::where('email',$email)->delete();
        return response()->json([
            'message'=>'El usuario se borro con exito.',
            'user'=>$user
        ]);
    }

    public function postUser(Request $request)
    {

        $validator = $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'email_verified_at'=>'required',
            'password'=>'required'
        ]);
        if($validator){
          $user = User::create([
                'name'=>$request->name,
                'last_name'=>$request->last_name,
                'photo'=>$request->photo,
                'avatar'=>$request->avatar,
                'status'=>$request->status,
                'google_sign_in'=>$request->google_sign_in,
                'email'=>$request->email,
                'email_verified_at'=>$request->email_verified_at,
                'password'=>$request->password,
            ]);
            return response()->json([
                'message'=>'El usuario se creo con éxito.',
                'user'=>$user
            ]);
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'user'=>$request
            ]);

        }
    }

}
