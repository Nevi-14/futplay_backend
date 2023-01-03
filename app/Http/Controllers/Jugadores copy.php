<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Jugador;


class Jugadores extends Controller
{
  
   
    public function getJugadoresEquipos($Cod_Equipo){

    
        $jugadores = Jugador::where('Cod_Equipo',  $Cod_Equipo)->with('equipos','usuarios')->get();
         
        $new = [];

        if(count($jugadores) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($jugadores) ; $i++) {
   
            $usuario = new \stdClass;
            $usuario->nombre = $jugadores[$i]->first()->usuarios->Nombre;
            $usuario->apellido = $jugadores[$i]->first()->usuarios->Primer_Apellido;
            $usuario->posicion = $jugadores[$i]->first()->usuarios->posiciones->Posicion;
            $usuario->partidos = $jugadores[$i]->first()->usuarios->Partidos_Jugados;
            $usuario->foto =  $jugadores[$i]->first()->usuarios->Foto;
            $usuario->avatar = $jugadores[$i]->first()->usuarios->Foto;
            $usuario->avatar = $jugadores[$i]->first()->usuarios->Avatar;
            $usuario->telefono = $jugadores[$i]->first()->usuarios->Compartir_Datos ? $jugadores[$i]->first()->usuarios->Telefono : null;
            $usuario->jugadorfp = $jugadores[$i]->first()->usuarios->Partidos_Jugador_Futplay;
            $usuario->jugador = $jugadores[$i]->first()->usuarios->posiciones->Partidos_Jugador_Del_Partido;
            $equipo = new \stdClass;
            $equipo->nombre = $jugadores[$i]->first()->equipos->Nombre;
            $equipo->abreviacion = $jugadores[$i]->first()->equipos->Abreviacion;
            $equipo->provincia = $jugadores[$i]->first()->equipos->provincias->Provincia;
            $equipo->canton = $jugadores[$i]->first()->equipos->cantones->Canton;
            $equipo->estrellas = $jugadores[$i]->first()->equipos->Estrellas;
            $equipo->dureza = $jugadores[$i]->first()->equipos->Dureza;
            $equipo->foto = $jugadores[$i]->first()->equipos->Foto;
            array_push($new,
          [
         'jugador' =>  $jugadores[$i]->withoutRelations(), 
          'usuario' => $usuario,
          'equipo' => $equipo
          
          ]
           );
           if($i == count($jugadores) -1){
            return $new;

           }
        
        }
     
        if($user){
            return response()->json([
                'action'=>true,
                'message'=>'Bienvenido',
                'usuario'=>$user->makeVisible(['Contrasena'])->withoutRelations(),
                'provincia'=>$user->provincias->Provincia,
                'canton'=>$user->cantones->Canton,
                'distrito'=>$user->distritos->Distrito,
                'posicion'=>$user->posiciones->Posicion,
            ]);

        }else{
            return response()->json([
                'action'=>false,
                'message'=>'Lo sentimos algo salio mal',
                'usuario'=>null
            ]);
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
        $jugador = Jugador::where('Cod_Jugador',$Cod_Jugador)->delete();
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
