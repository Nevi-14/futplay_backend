<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categoria;

class Categorias extends Controller
{
 
    public function getCategorias(){
      $categorias = Categoria::all();
      return response()->json($categorias);
    }

 

}
