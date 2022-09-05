<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
class offices extends Controller
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
        //
    }
    public function getOffices(){

        $offices = Office::all();
        

        return response()->json([
            'offices'=>$offices,
        ]);
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
    
    public function postOffice(Request $request)
    {

        $validator = $request->validate([
            'user_id'=>'required',
            'name'=>'required',
            'contact_number'=>'nullable',
            'description'=>'nullable',
            'default_office'=>'nullable',
            'favorite'=>'nullable',
            'created_at'=>'nullable',
            'updated_at'=>'nullable',
        ]);
        if($validator){
          $office = Office::create([
                'user_id'=>$request->user_id,
                'name'=>$request->name,
                'contact_number'=>$request->contact_number,
                'description'=>$request->description,
                'default_office'=>$request->default_office,
                'favorite'=>$request->favorite,
                'created_at'=>$request->created_at,
                'updated_at'=>$request->updated_at
            ]);
            return response()->json([
                'message'=>'El oficina se creo con éxito.',
                'user'=>$office
            ]);
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'user'=>$request
            ]);

        }
    }
    public function putOffice(Request $request)
    {
     

  
          $office = Office::where('id', $request->id)->update([
                'name'=>$request->name,
                'contact_number'=>$request->contact_number,
                'description'=>$request->description,
                'default_office'=>$request->default_office,
                'favorite'=>$request->favorite
            ]);

            if($office){
                return response()->json([
                    'message'=>'El oficina se actualizo con éxito.',
                    'user'=>$office
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'user'=>$office
                ]);
            
            }
           
    }
    public function userOffices($id){

        $offices = Office::where('user_id', $id)->get();
    
        return response()->json($offices);
    }

    public function deleteOffice($id)
    {
        $office = Office::where('id',$id)->delete();
        return response()->json([
            'message'=>'La sucursal se borro con exito.',
            'office'=>$office
        ]);
    }

}
