<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distrito;

class Distritos extends Controller
{
 
    public function getDistritos(){
 
      $distritos = Distrito::get();

        return response()->json($distritos);
    }

    public function getDistritosCantones($Cod_Canton){

       
      $distritos = Distrito::where('Cod_Canton', $Cod_Canton)->get();
      
      if(Count( $distritos)== 0) return response([], 404);

      return response()->json($distritos);
  }
}
