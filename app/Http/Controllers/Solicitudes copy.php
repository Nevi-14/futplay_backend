<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Solicitud;


class Solicitudes extends Controller
{
  
   
    public function getSolicitudesEquipos($Cod_Equipo){

    
        $solicitudes = Solicitud::where('Cod_Equipo',  $Cod_Equipo)->with('equipos','usuarios')->get();
         
        $new = [];

        if(count($solicitudes) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($solicitudes) ; $i++) {

            $usuario = new \stdClass;
            $usuario->nombre = $solicitudes[$i]->first()->usuarios->Nombre;
            $usuario->apellido = $solicitudes[$i]->first()->usuarios->Primer_Apellido;
            $usuario->posicion = $solicitudes[$i]->first()->usuarios->posiciones->Posicion;
            $usuario->partidos = $solicitudes[$i]->first()->usuarios->Partidos_Jugados;
            $usuario->apodo = $solicitudes[$i]->first()->usuarios->Apodo;
            $usuario->avatar = $solicitudes[$i]->first()->usuarios->Avatar;
            $usuario->telefono = $solicitudes[$i]->first()->usuarios->Compartir_Datos ? $solicitudes[$i]->first()->usuarios->Telefono : null;
            $usuario->jugadorfp = $solicitudes[$i]->first()->usuarios->Partidos_Jugador_Futplay;
            $usuario->jugador = $solicitudes[$i]->first()->usuarios->posiciones->Partidos_Jugador_Del_Partido;
            $equipo = new \stdClass;
            $equipo->nombre = $solicitudes[$i]->first()->equipos->Nombre;
            $equipo->abreviacion = $solicitudes[$i]->first()->equipos->Abreviacion;
            $equipo->provincia = $solicitudes[$i]->first()->equipos->provincias->Provincia;
            $equipo->canton = $solicitudes[$i]->first()->equipos->cantones->Canton;
            $equipo->estrellas = $solicitudes[$i]->first()->equipos->Estrellas;
            $equipo->dureza = $solicitudes[$i]->first()->equipos->Dureza;
            $equipo->foto = $solicitudes[$i]->first()->equipos->Foto;
            array_push($new,
          [
         'solicitud' =>  $solicitudes[$i]->withoutRelations(), 
          'usuario' => $usuario,
          'equipo' => $equipo
          
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
                'Estado'=>$request->Estad
            
            ]);

        
            if($solicitud){
                return response()->json([
                    'message'=>'La solicitud se actualizo con éxito.',
                    'solicitud'=>Solicitud::where('Cod_Solicitud', $request->Cod_Solicitud)->get()->first()
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
