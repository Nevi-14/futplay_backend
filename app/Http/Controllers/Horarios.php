<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use Illuminate\Support\Facades\Storage;
use File;



class Horarios extends Controller
{
  
    public function getHorario($Cod_Cancha){

        $horarios = Horario::where('Cod_Cancha',  $Cod_Cancha)->get();
        
        return  $horarios;
    }


  


    public function postHorario(Request $request)
    {


    
        $validator = $request->validate([
            'Cod_Cancha'=>'required',
            'Cod_Dia'=>'required',
            'Estado'=>'required',
            'Hora_Inicio'=>'required',
            'Hora_Fin'=>'required'
        ]);
        if($validator){
         
          $horario = Horario::create([
                'Cod_Cancha'=>$request->Cod_Cancha,
                'Cod_Dia'=>$request->Cod_Dia,
                'Estado'=>$request->Estado,
                'Hora_Inicio'=>$request->Hora_Inicio,
                'Hora_Fin'=>$request->Hora_Fin
            ]);
          
            return $horario;
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'horario'=>$request
            ]);

        }
    }

    public function putHorario(Request $request)
    {



        $horarios = Horario::where('Cod_Horario', $request->Cod_Horario)->where('Cod_Dia', $request->Cod_Dia)->update([
            'Cod_Cancha'=>$request->Cod_Cancha,
            'Cod_Dia'=>$request->Cod_Dia,
            'Estado'=>$request->Estado,
            'Hora_Inicio'=>$request->Hora_Inicio,
            'Hora_Fin'=>$request->Hora_Fin
            
            ]);

        
            if($horarios){
                return response()->json([
                    'message'=>'El horario se actualizo con éxito.',
                    'horarios'=>Horario::where('Cod_Cancha', $request->Cod_Cancha)->get()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'horarios'=>$request
                ]);
            
            }
    }


    public function deleteCancha($Cod_Cancha)
    {
        $horarios = Horario::where('Cod_Cancha',$Cod_Cancha)->delete();
        return response()->json([
            'message'=>'El horario se borro con exito.',
            'horarios'=>$horarios
        ]);
    }

}
