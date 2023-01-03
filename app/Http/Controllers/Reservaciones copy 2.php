<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservacion;
use App\Models\DetalleReservacion;
use Illuminate\Support\Facades\Storage;
use App\Models\Usuario;
use App\mail\email;
use Illuminate\Support\Facades\Mail;
use File;
use Carbon\Carbon;


class Reservaciones extends Controller
{
  
   

    public function getReservacionesCanchaDia(Request $request ){

        $reservaciones = Reservacion::where('Cod_Cancha', $request->Cod_Cancha)->where('Fecha', $request->Fecha)->get();
        return response()->json($reservaciones);

    


    }
    public function getReservacionesCanchaRango( Request $request){

        $reservaciones = Reservacion::with('canchas')->where('Cod_Cancha', $request->Cod_Cancha)->whereBetween('Fecha', [$request->Fecha_Inicio, $request->Fecha_Fin])->get();
       
        $new = [];

        if(count($reservaciones) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($reservaciones) ; $i++) {
            array_push($new,
          [
            'cancha' =>  $reservaciones[$i]->canchas,
          'reservacion' =>  $reservaciones[$i]->withoutRelations()
          
          
          ]
           );
           if($i == count($reservaciones) -1){
            return $new;

           }
        
        }
       
       
        return response()->json($reservaciones);
    }
   
    public function getVerificarDisponibilidadReservacion( Request $request){

        $reservaciones = Reservacion::where('Cod_Cancha', $request->Cod_Cancha)->where('Hora_Inicio','>=', $request->Hora_Inicio )->where('Hora_Fin','<=', $request->Hora_Fin)->get();
        return response()->json($reservaciones);
    }

    public function getReservacionesMovil(Request $request){

       $reservaciones =  DetalleReservacion::with('reservaciones','rival','retador')->whereRelation('retador','Cod_Usuario', $request->Cod_Usuario)->orwhereRelation('rival', 'Cod_Usuario',$request->Cod_Usuario)->get();
      
        $new = [];

        if(count($reservaciones) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($reservaciones) ; $i++) {
            array_push($new,
          [
            'cancha' =>  $reservaciones[$i]->reservaciones->canchas,
            'reservacion' =>  $reservaciones[$i]->reservaciones, 
          'detalle' =>  $reservaciones[$i]->withoutRelations(), 
          'rival' => $reservaciones[$i]->rival->withoutRelations(),
          'usuario_rival' => $reservaciones[$i]->rival->usuarios,
          'retador' => $reservaciones[$i]->retador->withoutRelations(),
          'usuario_retador' => $reservaciones[$i]->retador->usuarios
          
          
          ]
           );
           if($i == count($reservaciones) -1){
            return $new;

           }
        
        }
        
    }  public function getReservacionesEnviadas(Request $request){
        $date =  Carbon::now()->today('America/Costa_Rica');
        $reservaciones =  DetalleReservacion::with('reservaciones','rival','retador')->whereRelation('reservaciones','Cod_Estado', 2)
        ->whereRelation('reservaciones','Fecha', '>=', $date)->whereRelation('retador', 'Cod_Usuario',$request->Cod_Usuario)->get();
       
         $new = [];
 
         if(count($reservaciones) == 0){
          
 
             return $new;
         }
         for( $i =0; $i < count($reservaciones) ; $i++) {
             array_push($new,
           [
            'cancha' =>  $reservaciones[$i]->reservaciones->canchas->withoutRelations(),
           'reservacion' =>  $reservaciones[$i]->reservaciones->withoutRelations(), 
           'detalle' =>  $reservaciones[$i]->withoutRelations(), 
           'rival' => $reservaciones[$i]->rival->withoutRelations(),
           'usuario_rival' => $reservaciones[$i]->rival->usuarios,
           'retador' => $reservaciones[$i]->retador->withoutRelations(),
           'usuario_retador' => $reservaciones[$i]->retador->usuarios,
           'categoria' => $reservaciones[$i]->reservaciones->canchas->categorias->Nombre,
           'correo' => $reservaciones[$i]->reservaciones->canchas->usuarios->Correo,
           'provincia' => $reservaciones[$i]->reservaciones->canchas->provincias->Provincia,
           'canton' => $reservaciones[$i]->reservaciones->canchas->cantones->Canton,
           'distrito' => $reservaciones[$i]->reservaciones->canchas->distritos->Distrito,
           
           
           ]
            );
            if($i == count($reservaciones) -1){
             return $new;
 
            }
         
         }
         
     }

    public function getReservacionesRecibidas(Request $request){
        $date =  Carbon::now()->today('America/Costa_Rica');
        $reservaciones =  DetalleReservacion::with('reservaciones','rival','retador')->where('Cod_Estado', 3)->whereRelation('reservaciones','Fecha', '>=', $date)->whereRelation('rival', 'Cod_Usuario',$request->Cod_Usuario)->get();
       
         $new = [];
 
         if(count($reservaciones) == 0){
          
 
             return $new;
         }
         for( $i =0; $i < count($reservaciones) ; $i++) {
             array_push($new,
           [
             'cancha' =>  $reservaciones[$i]->reservaciones->canchas,
             'reservacion' =>  $reservaciones[$i]->reservaciones, 
           'detalle' =>  $reservaciones[$i]->withoutRelations(), 
           'rival' => $reservaciones[$i]->rival->withoutRelations(),
           'usuario_rival' => $reservaciones[$i]->rival->usuarios,
           'retador' => $reservaciones[$i]->retador->withoutRelations(),
           'usuario_retador' => $reservaciones[$i]->retador->usuarios,
           'categoria' => $reservaciones[$i]->reservaciones->canchas->categorias->Nombre,
           'correo' => $reservaciones[$i]->reservaciones->canchas->usuarios->Correo,
           'provincia' => $reservaciones[$i]->reservaciones->canchas->provincias->Provincia,
           'canton' => $reservaciones[$i]->reservaciones->canchas->cantones->Canton,
           'distrito' => $reservaciones[$i]->reservaciones->canchas->distritos->Distrito,
           
           
           ]
            );
            if($i == count($reservaciones) -1){
             return $new;
 
            }
         
         }
         
     }
     public function getReservacionesHistorial(Request $request){
        $date =  Carbon::now()->today('America/Costa_Rica');
        $reservaciones =  DetalleReservacion::with('reservaciones','rival','retador')->where('Cod_Estado', 6)->whereRelation('reservaciones','Cod_Estado', 6)->get();
       
         $new = [];
 
         if(count($reservaciones) == 0){
          
 
             return $new;
         }
         for( $i =0; $i < count($reservaciones) ; $i++) {
             array_push($new,
           [
             'cancha' =>  $reservaciones[$i]->reservaciones->canchas,
             'reservacion' =>  $reservaciones[$i]->reservaciones, 
           'detalle' =>  $reservaciones[$i]->withoutRelations(), 
           'rival' => $reservaciones[$i]->rival->withoutRelations(),
           'usuario_rival' => $reservaciones[$i]->rival->usuarios,
           'retador' => $reservaciones[$i]->retador->withoutRelations(),
           'usuario_retador' => $reservaciones[$i]->retador->usuarios,
           'categoria' => $reservaciones[$i]->reservaciones->canchas->categorias->Nombre,
           'provincia' => $reservaciones[$i]->reservaciones->canchas->provincias->Provincia,
           'correo' => $reservaciones[$i]->reservaciones->canchas->usuarios->Correo,
           'canton' => $reservaciones[$i]->reservaciones->canchas->cantones->Canton,
           'distrito' => $reservaciones[$i]->reservaciones->canchas->distritos->Distrito,
           
           ]
            );
            if($i == count($reservaciones) -1){
             return $new;
 
            }
         
         }
         
     }

     
     public function getReservacionesConfirmadas(Request $request){
        $date =  Carbon::now('America/Costa_Rica');
        $newDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)
        ->format('Y-m-d');
//  $newDate;
        $reservaciones =  DetalleReservacion::with('reservaciones','rival','retador')
        ->whereRelation('retador', 'Cod_Usuario',$request->Cod_Usuario)
        ->orwhereRelation('rival', 'Cod_Usuario',$request->Cod_Usuario)
        ->whereRelation('reservaciones','Fecha', '>=', $newDate)
        ->whereRelation('reservaciones','Cod_Estado', 4)
        ->get();
       return $reservaciones;
         $new = [];
 
         if(count($reservaciones) == 0){
          
 
             return $new;
         }
         for( $i =0; $i < count($reservaciones) ; $i++) {
             array_push($new,
           [
             'cancha' =>  $reservaciones[$i]->reservaciones->canchas,
             'reservacion' =>  $reservaciones[$i]->reservaciones, 
           'detalle' =>  $reservaciones[$i]->withoutRelations(), 
           'rival' => $reservaciones[$i]->rival->withoutRelations(),
           'usuario_rival' => $reservaciones[$i]->rival->usuarios,
           'retador' => $reservaciones[$i]->retador->withoutRelations(),
           'usuario_retador' => $reservaciones[$i]->retador->usuarios,
           'categoria' => $reservaciones[$i]->reservaciones->canchas->categorias->Nombre,
           'provincia' => $reservaciones[$i]->reservaciones->canchas->provincias->Provincia,
           'correo' => $reservaciones[$i]->reservaciones->canchas->usuarios->Correo,
           'canton' => $reservaciones[$i]->reservaciones->canchas->cantones->Canton,
           'distrito' => $reservaciones[$i]->reservaciones->canchas->distritos->Distrito,
           
           ]
            );
            if($i == count($reservaciones) -1){
             return $new;
 
            }
         
         }
         
     }
     public function getReservacionesResvision(Request $request){
        $date =  Carbon::now('America/Costa_Rica');
        $newDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)
        ->format('Y-m-d');
//  $newDate;
        $reservaciones =  DetalleReservacion::with('reservaciones','rival','retador')
        ->whereRelation('retador', 'Cod_Usuario',$request->Cod_Usuario)
        ->orwhereRelation('rival', 'Cod_Usuario',$request->Cod_Usuario)
        ->whereRelation('reservaciones','Fecha', '>=', $newDate)
        ->whereRelation('reservaciones','Cod_Estado', '=', 7)
        ->orwhereRelation('reservaciones', 'Cod_Estado', '=',8)
        ->get();
       
         $new = [];
 
         if(count($reservaciones) == 0){
          
 
             return $new;
         }
         for( $i =0; $i < count($reservaciones) ; $i++) {
             array_push($new,
           [
             'cancha' =>  $reservaciones[$i]->reservaciones->canchas,
             'reservacion' =>  $reservaciones[$i]->reservaciones, 
           'detalle' =>  $reservaciones[$i]->withoutRelations(), 
           'rival' => $reservaciones[$i]->rival->withoutRelations(),
           'usuario_rival' => $reservaciones[$i]->rival->usuarios,
           'retador' => $reservaciones[$i]->retador->withoutRelations(),
           'usuario_retador' => $reservaciones[$i]->retador->usuarios,
           'categoria' => $reservaciones[$i]->reservaciones->canchas->categorias->Nombre,
           'provincia' => $reservaciones[$i]->reservaciones->canchas->provincias->Provincia,
           'correo' => $reservaciones[$i]->reservaciones->canchas->usuarios->Correo,
           'canton' => $reservaciones[$i]->reservaciones->canchas->cantones->Canton,
           'distrito' => $reservaciones[$i]->reservaciones->canchas->distritos->Distrito,
           
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

   
    public function deleteReservacion(Request $request)
    {

        $verificar = Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->first();


    
        if($verificar['Cod_Estado'] == 2){
            
            $reservacion = Reservacion::where('Cod_Reservacion',$request->Cod_Reservacion)->delete();
  
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


        }else{
           Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
                'Cod_Estado'=>7
                
                ]);

DetalleReservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
                    'Cod_Estado'=>7,
                    'Notas_Estado'=> 'Reservacion cancelada, pendiente verificacion'
                    
                    ]);
                    return response()->json([
                        'action'=>true,
                        'message'=>'Reservacion cancelada, pendiente verificacion',
                        'reservacion'=> Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->first()
                    ]);

        }

   
    }


    public function CorreoReservacion(Request $request)
    {
   
    $email =  $request->body['email'];
    $body = $request->body['body'];
    $footer = $request->body['footer'];
    $user = Usuario::where('Correo', $email)->orWhere('Telefono', $email)->get()->first();
   
   if($user){

    $name = $user->Nombre;
    Mail::to($user->Correo)->send(new email($name,$body, $footer ));
    return response()->json([
        'message'=>'Se ha enviado una notificacion al correo',
        
    ]);
   } else{
    return response()->json([
        'message'=>'Lo sentimos algo salio mal.'
    ]);
   }


    }

}
