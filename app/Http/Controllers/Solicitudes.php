<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Jugador;

class Solicitudes extends Controller
{
  
   // SOLICITUDES ENVIADAS EQUIPO  Cod_Equipo = Cod_Equipo  && Confirmacion_Equipo = TRUE


    public function getSolicitudesEnviadasEquipos($Cod_Equipo){


        $solicitudes = Solicitud::where('Cod_Equipo',  $Cod_Equipo)->where('Confirmacion_Equipo','=',true)->with('equipos','usuarios')->get();
        $new = [];

        if(count($solicitudes) == 0){
            return $new;
        }
        for( $i =0; $i < count($solicitudes) ; $i++) {
            array_push($new,
          [
         'solicitud' =>  $solicitudes[$i]->withoutRelations(), 
         'usuario'=>$solicitudes[$i]->usuarios,
         'provincia'=>$solicitudes[$i]->usuarios->provincias,
         'canton'=>$solicitudes[$i]->usuarios->cantones,
         'distrito'=>$solicitudes[$i]->usuarios->distritos,
         'posicion'=>$solicitudes[$i]->usuarios->posiciones->Posicion,
          'equipo' => $solicitudes[$i]->equipos,
             
          ]
           );
           if($i == count($solicitudes) -1){
            return $new;

           }
        
        }
     

      
    }


// SOLICITUDES RECIBIDAS EQUIPO  Cod_Equipo = Cod_Equipo  && Confirmacion_Equipo = FALSE


public function getSolicitudesRecibidasEquipos($Cod_Equipo){

    $solicitudes = Solicitud::where('Cod_Equipo',  $Cod_Equipo)->where('Confirmacion_Equipo','=',false)->with('equipos','usuarios')->get();

    $new = [];

    if(count($solicitudes) == 0){
        return $new;
    }
    for( $i =0; $i < count($solicitudes) ; $i++) {
        array_push($new,
      [
     'solicitud' =>  $solicitudes[$i]->withoutRelations(), 
     'usuario'=>$solicitudes[$i]->usuarios,
     'provincia'=>$solicitudes[$i]->usuarios->provincias,
     'canton'=>$solicitudes[$i]->usuarios->cantones,
     'distrito'=>$solicitudes[$i]->usuarios->distritos,
     'posicion'=>$solicitudes[$i]->usuarios->posiciones->Posicion,
      'equipo' => $solicitudes[$i]->equipos   
      ]
       );
       if($i == count($solicitudes) -1){
        return $new;

       }
    
    }
 

  
}
// SOLICITUDES RECIBIDAS USUARIO  Cod_Usuario = Cod_Usuario  && Confirmacion_Usuario = FALSE


public function getSolicitudesRecibidasUsuarios(Request $request){

    
    $solicitudes = Solicitud::where('Cod_Usuario',  $request->Cod_Usuario)->where('Confirmacion_Usuario','=',false)->with('equipos','usuarios')->get();      
    $new = [];
    if(count($solicitudes) == 0){  
        return $new;
    }
    for( $i =0; $i < count($solicitudes) ; $i++) {

        array_push($new,
      [
     'solicitud' =>  $solicitudes[$i]->withoutRelations(), 
      'usuario' => $solicitudes[$i]->usuarios,
      'equipo' => $solicitudes[$i]->equipos
      
      ]
       );
       if($i == count($solicitudes) -1){
        return $new;

       }
    
    }
 

  
}


 // SOLICITUDES ENVIADAS USUARIO  Cod_Usuario = Cod_Usuario  && Confirmacion_Usuario = TRUE

    public function getSolicitudesEnviadasUsuarios(Request $request){

    
        $solicitudes = Solicitud::where('Cod_Usuario',  $request->Cod_Usuario)->where('Confirmacion_Usuario','=',true)->with('equipos','usuarios')->get();      
        $new = [];
        if(count($solicitudes) == 0){  
            return $new;
        }
        for( $i =0; $i < count($solicitudes) ; $i++) {

            array_push($new,
          [
         'solicitud' =>  $solicitudes[$i]->withoutRelations(), 
          'usuario' => $solicitudes[$i]->usuarios,
          'equipo' => $solicitudes[$i]->equipos
          
          ]
           );
           if($i == count($solicitudes) -1){
            return $new;

           }
        
        }
     

      
    }
    public function postSolicitud(Request $request)
    {
    
        $validator = $request->validate([
            'Cod_Usuario'=>'required',  
            'Cod_Equipo'=>'required',
            'Confirmacion_Usuario'=>'required',
            'Confirmacion_Equipo'=>'required',
            'Estado'=>'required'
            
        ]);
        if($validator){
          $soliciud = Solicitud::create([
                'Cod_Usuario'=>$request->Cod_Usuario,
                'Cod_Equipo'=>$request->Cod_Equipo,
                'Confirmacion_Usuario'=>$request->Confirmacion_Usuario,
                'Confirmacion_Equipo'=>$request->Confirmacion_Equipo,
                'Estado'=>$request->Estado
            ]);
          
            return $soliciud;
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'soliciud'=>$request
            ]);

        }
    }

    public function putSolicitud(Request $request)
    {

        $solicitud = Solicitud::where('Cod_Solicitud', $request->Cod_Solicitud)->update([
                'Confirmacion_Usuario'=>$request->Confirmacion_Usuario,
                'Confirmacion_Equipo'=>$request->Confirmacion_Equipo,
                'Estado'=>$request->Estado
            
            ]);

        
            if($solicitud){

                if($request->Confirmacion_Usuario &&  $request->Confirmacion_Equipo){
                    $jugador = Jugador::create([
                        'Cod_Usuario'=>$request->Cod_Usuario,
                        'Cod_Equipo'=>$request->Cod_Equipo,
                        'Favorito'=>false,
                        'Administrador'=>false
                    ]);

              

                }
               
                Solicitud::where('Cod_Solicitud', $request->Cod_Solicitud)->delete();
                return response()->json([
                    'message'=>'La solicitud se actualizo con éxito.',
                    'solicitud'=>null
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'solicitud'=>$request
                ]);
            
            }
    }

 

    
    public function deleteSolicitud(Request $request)
    {
        $solicitud = Solicitud::where('Cod_Solicitud',$Cod_Solicitud)->delete();
      if($solicitud == 1){

        return response()->json([
            'action'=>true,
            'message'=>'La solicitud se borro con exito.',
            'solicitud'=>$solicitud
        ]);

      }else{

        return response()->json([
            'action'=>false,
            'message'=>'Error Borrando la solicitud',
            'solicitud'=>$solicitud
        ]);
    }
    }




}
