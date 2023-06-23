<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provincia;

class Provincias extends Controller
{
 
    public function getProvincias(){

        $provincias = Provincia::all();
        return response()->json($provincias);
    }

  
}
