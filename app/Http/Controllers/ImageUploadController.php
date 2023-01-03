<?php

namespace App\Http\Controllers;
use App\Models\Images;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $images = Images::all();

        return view('images.index')->with('images', $images);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view ('images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //it works with storage link  php artisan storage:link

        $requestData = $request->all();
        $fileName = time().$request->file('photo')->getClientOriginalName();
        $path = $request->file('photo')->storeAs('images', $fileName, 'public');
        $requestData["photo"] = '/storage/'.$path;
        Images::create($requestData);

        return redirect('images')->with('flash_message','Image Added!');
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
        $image = Images::findOrFail($id);
        return view ('images.edit')->with('image', $image);
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
    
        $image = Images::findOrFail($id);

        if($request->file('photo')){
            if(file_exists(public_path($image->photo))){
                unlink(public_path($image->photo));
               
              }
              $fileName = time().$request->file('photo')->getClientOriginalName();
              $path = $request->file('photo')->storeAs('images', $fileName, 'public');
              $image->photo =  '/storage/'.$path;

        }
        $image->name = $request->name;
      

        $image->save();
        
        return redirect('/images');


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

        $image = Images::findOrFail($id);
        
     //   dd($image->photo);
        if(file_exists(public_path($image->photo))){
            unlink(public_path($image->photo));
            $image->delete();
          }else{
            dd('File not found');
          }


   return redirect('/images');
    }
}
