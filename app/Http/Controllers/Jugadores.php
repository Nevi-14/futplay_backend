<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Jugador;
use App\Models\Solicitud;


class Jugadores extends Controller
{
  
    public function getJugador(Request $request)
    {
    $jugador = Jugador::where('Cod_Usuario',  $request->Cod_Usuario)->where('Cod_Equipo',  $request->Cod_Equipo)->get();
    if(count($jugador) == 0){
         
        $solicitudes = Solicitud::where('Cod_Usuario',  $request->Cod_Usuario)->get();
        return $solicitudes;
    }
    return  $jugador;
}
    public function getJugadoresEquipos($Cod_Equipo){

    
        $jugadores = Jugador::where('Cod_Equipo',  $Cod_Equipo)->with('equipos','usuarios')->get();
         
        $new = [];

        if(count($jugadores) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($jugadores) ; $i++) {
   
         
            array_push($new,
            [
                'jugador'=>$jugadores[$i]->withoutRelations(),
                'usuario'=>$jugadores[$i]->usuarios->withoutRelations(),
                'equipo'=>$jugadores[$i]->equipos->withoutRelations(),
                'canton'=>$jugadores[$i]->usuarios->cantones->Canton,
                'distrito'=>$jugadores[$i]->usuarios->distritos->Distrito,
                'posicion'=>$jugadores[$i]->usuarios->posiciones->Posicion,
            ]
           );
           if($i == count($jugadores) -1){
            return $new;

           }
        
        }
     
     
      
    }


    public function postJugador(Request $request)
    {
    
        $validator = $request->validate([
            'Cod_Usuario'=>'required',  
            'Cod_Equipo'=>'required',
            'Favorito'=>'required',
            'Administrador'=>'required'
            
        ]);
        if($validator){
          $jugador = Jugador::create([
                'Cod_Usuario'=>$request->Cod_Usuario,
                'Cod_Equipo'=>$request->Cod_Equipo,
                'Favorito'=>$request->Favorito,
                'Administrador'=>$request->Administrador
            ]);
          
            return $jugador;
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'jugador'=>$request
            ]);

        }
    }

    public function putJugador(Request $request)
    {

        $jugador = Jugador::where('Cod_Jugador', $request->Cod_Jugador)->update([
            'Favorito'=>$request->Favorito,
            'Administrador'=>$request->Administrador
            
            ]);

        
            if($jugador){
                return response()->json([
                    'message'=>'El jugador se actualizo con éxito.',
                    'jugador'=>Jugador::where('Cod_Jugador', $request->Cod_Jugador)->get()->first()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'jugador'=>$request
                ]);
            
            }
    }

 

    
    public function deleteJugador(Request $request)
    {
        $jugador = Jugador::where('Cod_Jugador',$request->Cod_Jugador)->delete();
      if($jugador == 1){

        return response()->json([
            'action'=>true,
            'message'=>'El jugador se borro con exito.',
            'jugador'=>$jugador
        ]);

      }else{

        return response()->json([
            'action'=>false,
            'message'=>'Error Borrando El jugador',
            'jugador'=>$jugador
        ]);
    }
    }




}
