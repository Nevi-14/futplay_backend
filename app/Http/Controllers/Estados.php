<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;

class Estados extends Controller
{
 
    public function getEstados(){

        $estados = Estado::all();
        
        return response()->json($estados);
    }

  
}
