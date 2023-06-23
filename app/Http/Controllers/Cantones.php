<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Canton;

class Cantones extends Controller
{
 
    public function getCantones(){

   
      $cantones = Canton::all();

      return response()->json($cantones);
    }

    public function getCantonesProvincias($Cod_Provincia){

       
      $cantones = Canton::where('Cod_Provincia', $Cod_Provincia)->get();
      
      if(Count($cantones)== 0)  return response([], 404) ;

      return response()->json($cantones);
  }

}
