<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posicion;

class Posiciones extends Controller
{
 
    public function getPosiciones(){

        $posiciones = Posicion::all();
        return response()->json($posiciones);
    }

  
}
