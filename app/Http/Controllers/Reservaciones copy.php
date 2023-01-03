<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservacion;
use Illuminate\Support\Facades\Storage;
use File;



class Reservaciones extends Controller
{
  
   

    public function getReservacionesCanchaDia(Request $request ){

        $reservaciones = Reservacion::where('Cod_Cancha', $request->Cod_Cancha)->where('Fecha', $request->Fecha)->get();
        return response()->json($reservaciones);

    


    }
    public function getReservacionesCanchaRango( Request $request){

        $reservaciones = Reservacion::where('Cod_Cancha', $request->Cod_Cancha)->whereBetween('Fecha', [$request->Fecha_Inicio, $request->Fecha_Fin])->get();
        return response()->json($reservaciones);
    }
   
    public function getVerificarDisponibilidadReservacion( Request $request){

        $reservaciones = Reservacion::where('Cod_Cancha', $request->Cod_Cancha)->where('Hora_Inicio','>=', $request->Hora_Inicio )->where('Hora_Fin','<=', $request->Hora_Fin)->get();
        return response()->json($reservaciones);
    }

    public function getReservacionesMovil(Request $request){

       $reservaciones =  Reservacion::select('*')
        ->join('detalle_reservaciones', 'reservaciones.Cod_Reservacion', '=', 'detalle_reservaciones.Cod_Reservacion')
        ->get();

        $new = [];

        if(count($reservaciones) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($reservaciones) ; $i++) {
            array_push($new,
          ['reservacion' =>  $reservaciones[$i], 
          'rival' => $reservaciones[$i]->detalles()->rival,
          'retador' => $reservaciones[$i]->detalles()->retador
          
          
          
          ]
           );
           if($i == count($reservaciones) -1){
            return $new;

           }
        
        }
        
    }
    public function postReservacion(Request $request)
    {

        $validator = $request->validate([

            'Cod_Usuario'=>'required',
            'Cod_Cancha'=>'required',
            'Cod_Estado'=>'required',
            'Reservacion_Externa'=>'required',
            'Titulo'=>'required',
            'Dia_Completo'=>'required'
        ]);
        if($validator){
          $reservacion = Reservacion::create([
                'Cod_Usuario'=>$request->Cod_Usuario,
                'Cod_Cancha'=>$request->Cod_Cancha,
                'Cod_Estado'=>$request->Cod_Estado,
                'Reservacion_Externa'=>$request->Reservacion_Externa,
                'Titulo'=>$request->Titulo,
                'Fecha'=>$request->Fecha,
                'Hora_Inicio'=>$request->Hora_Inicio,
                'Hora_Fin'=>$request->Hora_Fin,
                'Dia_Completo'=>$request->Dia_Completo
            ]);
          
            return response()->json([
                'message'=>'La reservacion se creo con éxito.',
                'reservacion'=>$reservacion
            ]);
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'reservacion'=>false
            ]);

        }
    }

    public function putReservacion(Request $request)
    {



      
    
        $reservacion = Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([

            'Cod_Cancha'=>$request->Cod_Cancha,
            'Cod_Estado'=>$request->Cod_Estado,
            'Reservacion_Externa'=>$request->Reservacion_Externa,
            'Titulo'=>$request->Titulo,
            'Fecha'=>$request->Fecha,
            'Hora_Inicio'=>$request->Hora_Inicio,
            'Hora_Fin'=>$request->Hora_Fin,
            'Dia_Completo'=>$request->Dia_Completo
            
            ]);

        
            if($reservacion){
                return response()->json([
                    'message'=>'La reservacion se actualizo con éxito.',
                    'reservacion'=>Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->get()->first()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'reservacion'=>false
                ]);
            
            }
    }

    public function putEstadoReservacion(Request $request)
    {

        $cancha = Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
            'Estado'=>!$findCancha->Estado,
            'Descripcion_Estado'=> !$findCancha->Estado ? 'Cancha Activa' :'Cancha Inactiva'
            
            ]);


        
            if($cancha){
                return response()->json([
                    'message'=>'La reservacion se actualizo con éxito.',
                    'reservacion'=>Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->get()->first()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'reservacion'=>$request
                ]);


    }
    
}

   
    public function deleteReservacion($Cod_Reservacion)
    {
        $reservacion = Reservacion::where('Cod_Reservacion',$Cod_Reservacion)->delete();
  
      if($reservacion == 1){

        return response()->json([
            'action'=>true,
            'message'=>'La reservacion se borro con exito.',
            'reservacion'=>$reservacion
        ]);

      }else{

        return response()->json([
            'action'=>false,
            'message'=>'Error Borrando La Reservacion',
            'reservacion'=>$reservacion
        ]);
    }
    }




}
