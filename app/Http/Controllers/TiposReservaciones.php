<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
use App\Models\TipoReservacion;
 
class TiposReservaciones extends Controller
{
    public function getTiposReservaciones(){

   
        $tipos = TipoReservacion::all();
  
        return response()->json($tipos);
      }
}
