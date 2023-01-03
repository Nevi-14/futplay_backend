<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cancha;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\HistorialPartido;
use App\Models\HistorialPartidoEquipo;

use Illuminate\Support\Facades\Storage;
use File;



class Equipos extends Controller
{
  


    public function getFiltroEquipos(Request $request){

        $equipos =   [];
       
   
        if ($request->Cod_Provincia  != 'null' && $request->Cod_Canton  != 'null'   && $request->Cod_Distrito  != 'null'){
            
            $equipos =  Equipo::with('provincias','cantones','distritos','usuarios')
            ->whereRelation('provincias','Cod_Provincia', $request->Cod_Provincia)
            ->whereRelation('cantones','Cod_Canton', $request->Cod_Canton)
            ->whereRelation('distritos','Cod_Distrito', $request->Cod_Distrito)
            ->Where('Estado', 1)->get();
        
        }else if ($request->Cod_Provincia  != 'null' && $request->Cod_Canton  != 'null'){
            
            $equipos =  Equipo::with('provincias','cantones','distritos','usuarios')
            ->whereRelation('provincias','Cod_Provincia', $request->Cod_Provincia)
            ->whereRelation('cantones','Cod_Canton', $request->Cod_Canton)
            ->Where('Estado', 1)->get();
        
         
        }else if($request->Cod_Provincia != 'null'){

            $equipos =  Equipo::with('provincias','cantones','distritos','usuarios')
            ->whereRelation('provincias','Cod_Provincia', $request->Cod_Provincia)
            ->Where('Estado', 1)->get();
        }
        




 


        


       
        $new = [];

        if(count($equipos) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($equipos) ; $i++) {
            array_push($new,
          [
            'nombre' =>  $equipos[$i]->Nombre,
            'equipo' =>  $equipos[$i]->withoutRelations(), 
          'provincia' => $equipos[$i]->provincias->Provincia,
          'canton' => $equipos[$i]->cantones->Canton,
          'distrito' => $equipos[$i]->distritos->Distrito,
          'correo' => $equipos[$i]->usuarios->Correo
          
          
          ]
           );
           if($i == count($equipos) -1){
            return $new;

           }
        
        }
     
    }




    public function getEquipos(Request $request){
        $equipos = Equipo::where('Cod_Usuario','!=' , $request->Cod_Usuario)->with('provincias','cantones','distritos','usuarios')->get();
         
        $new = [];

        if(count($equipos) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($equipos) ; $i++) {
            array_push($new,
          [
            'nombre' =>  $equipos[$i]->Nombre,
            'equipo' =>  $equipos[$i]->withoutRelations(), 
          'provincia' => $equipos[$i]->provincias->Provincia,
          'canton' => $equipos[$i]->cantones->Canton,
          'distrito' => $equipos[$i]->distritos->Distrito,
          'correo' => $equipos[$i]->usuarios->Correo
          
          
          ]
           );
           if($i == count($equipos) -1){
            return $new;

           }
        
        }
    }
    public function getEquiposClasificacion(){
        $equipos = Equipo::with('provincias','cantones','distritos','usuarios')->orderBy('Puntaje_Actual','DESC')->limit(10)->get();
         
        $new = [];

        if(count($equipos) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($equipos) ; $i++) {
            array_push($new,
          [
            'nombre' =>  $equipos[$i]->Nombre,
            'equipo' =>  $equipos[$i]->withoutRelations(), 
          'provincia' => $equipos[$i]->provincias->Provincia,
          'canton' => $equipos[$i]->cantones->Canton,
          'distrito' => $equipos[$i]->distritos->Distrito,
          'correo' => $equipos[$i]->usuarios->Correo
          
          
          ]
           );
           if($i == count($equipos) -1){
            return $new;

           }
        
        }
    }
    public function getUsuarioEquipos(Request $request){

        

       // $equipos = Equipo::where('Cod_Usuario',  $Cod_Usuario)->with('provincias','cantones','distritos','usuarios')->get();
        $equipos = Jugador::where('Cod_Usuario',  $request->Cod_Usuario)->with('equipos','usuarios')->get();

    
        $new = [];

        if(count($equipos) == 0){
         

            return $new;
        }


        for( $i =0; $i < count($equipos) ; $i++) {
            array_push($new,
          [

          'nombre' =>  $equipos[$i]->equipos->Nombre,
          'equipo' =>  $equipos[$i]->equipos->withoutRelations(), 
          'provincia' => $equipos[$i]->equipos->provincias->Provincia,
          'canton' => $equipos[$i]->equipos->cantones->Canton,
          'distrito' => $equipos[$i]->equipos->distritos->Distrito,
          'correo' => $equipos[$i]->equipos->usuarios->Correo
          
          
          ]
           );
           if($i == count($equipos) -1){

             
            return $new;

           }
        
        }
     

      
    }


    public function postEquipo(Request $request)
    {
    
 

        $validator = $request->validate([
            'Cod_Usuario'=>'required',  
            'Cod_Provincia'=>'required',
            'Cod_Canton'=>'required',
            'Cod_Distrito'=>'required',
            'Foto'=>'required',
            'Avatar'=>'required',
            'Dureza'=>'required',
            'Nombre'=>'required',
            'Abreviacion'=>'required',
            
        ]);
        if($validator){
          $equipo = Equipo::create([
                'Cod_Usuario'=>$request->Cod_Usuario,
                'Cod_Provincia'=>$request->Cod_Provincia,
                'Cod_Canton'=>$request->Cod_Canton,
                'Cod_Distrito'=>$request->Cod_Distrito,
                'Avatar'=>$request->Avatar,
                'Foto'=>$request->Foto,
                'Dureza'=>$request->Dureza,
                'Nombre'=>$request->Nombre,
                'Abreviacion'=>$request->Abreviacion,
                'Estrellas_Anteriores'=>1
            ]);
          
            return $equipo;
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'equipo'=>$request
            ]);

        }
    }

    public function putEquipo(Request $request)
    {



  
    
        $equipo = Equipo::where('Cod_Equipo', $request->Cod_Equipo)->update([
            'Cod_Provincia'=>$request->Cod_Provincia,
            'Cod_Canton'=>$request->Cod_Canton,
            'Cod_Distrito'=>$request->Cod_Distrito,
            'Foto'=>$request->Foto,
            'Avatar'=>$request->Avatar,
            'Nombre'=>$request->Nombre,
            'Abreviacion'=>$request->Abreviacion,
            'Promedio_Altura_Jugadores'=>$request->Promedio_Altura_Jugadores,
            'Promedio_Peso_Jugadores'=>$request->Promedio_Peso_Jugadores
            
            ]);

        
            if($equipo){
                return response()->json([
                    'action'=>true,
                    'message'=>'El equipo se actualizo con éxito.',
                    'equipo'=>Equipo::where('Cod_Equipo', $request->Cod_Equipo)->get()->first()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'equipo'=>$request
                ]);
            
            }
    }

    public function putEstadoEquipo(Request $request)
    {

        $findEquipo = Equipo::where('Cod_Equipo', $request->Cod_Equipo)->get()->first();
  
    
     if($findEquipo){

        $equipo = Equipo::where('Cod_Equipo', $request->Cod_Equipo)->update([
            'Estado'=>!$findEquipo->Estado,
            'Descripcion_Estado'=> !$findEquipo->Estado ? 'Cancha Activa' :'Cancha Inactiva'
            
            ]);


        
            if($cancha){
                return response()->json([
                    'action'=>true,
                    'message'=>'El equipo se actualizo con éxito.',
                    'equipo'=>Equipo::where('Cod_Equipo', $request->Cod_Equipo)->get()->first()
                ]);
            
            }else{
                return response()->json([
                    'action'=>false,
                    'message'=>'Lo sentimos algo salio mal.',
                    'equipo'=>$request
                ]);
            
            }




     }else{
        return response()->json([
            'message'=>'Lo sentimos algo salio mal.',
            'cancha'=>$request
        ]);
    
    }


    }
    public function postDurezaEquipo(Request $request)
    {

        HistorialPartidoEquipo::create([
            'Cod_Equipo'=>$request->Cod_Equipo,
            'Dureza'=>$request->Dureza
        ]);
      

        $moda = HistorialPartidoEquipo::select('Dureza')
        ->groupBy('Dureza')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->where('Cod_Equipo', $request->Cod_Equipo)
        ->get();


       
        $findEquipo = HistorialPartido::where('Cod_Equipo', $request->Cod_Equipo)->get()->first();
        $equipo = Equipo::where('Cod_Equipo', $request->Cod_Equipo)->update([
            'Dureza'=> $moda[0]['Dureza']
            ]);

        
            return response()->json([
                'message'=>'El equipo se actualizo con éxito.',
                'equipo'=>Equipo::where('Cod_Equipo', $request->Cod_Equipo)->get()->first()
            ]);
    }

    public function putEstadisticaEquipo(Request $request)
    {

        $findEquipo = Equipo::where('Cod_Equipo', $request->Cod_Equipo)->get()->first();
  
    
     if($findEquipo){

        $equipo = Equipo::where('Cod_Equipo', $request->Cod_Equipo)->update([
            'Avatar'=>$request->Avatar,
            'Estrellas'=>$request->Estrellas,
            'Estrellas_Anteriores'=>$request->Estrellas_Anteriores,
            'Posicion_Actual'=>$request->Posicion_Actual,
            'Puntaje_Actual'=>$request->Puntaje_Actual,
            'Partidos_Ganados'=>$request->Partidos_Ganados,
            'Partidos_Perdidos'=>$request->Partidos_Perdidos,
            'Goles_Favor'=>$request->Goles_Favor,
            'Goles_Encontra'=>$request->Goles_Encontra,
            
            ]);


        
            if($cancha){
                return response()->json([
                    'action'=>true,
                    'message'=>'El equipo se actualizo con éxito.',
                    'equipo'=>Equipo::where('Cod_Equipo', $request->Cod_Equipo)->get()->first()
                ]);
            
            }else{
                return response()->json([
                    'action'=>false,
                    'message'=>'Lo sentimos algo salio mal.',
                    'equipo'=>$request
                ]);
            
            }




     }else{
        return response()->json([
            'message'=>'Lo sentimos algo salio mal.',
            'cancha'=>$request
        ]);
    
    }


    }



    public function putEquipoAvatar(Request $request)
    {
     
        $equipo = Equipo::where('Cod_Equipo', $request->Cod_Equipo)->update([
            'Avatar'=>$request->Avatar,
            'Foto'=>$request->Foto
            ]);

        
            if($equipo){
                return response()->json([
                    'message'=>'El equipo se actualizo con éxito.',
                    'equipo'=>Equipo::where('Cod_Equipo', $request->Cod_Equipo)->get()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'equipo'=>$equipo
                ]);
            
            }
    }

    public function postFotoEquipo(Request $request)
    {
        $message = "";
        $equipo = Equipo::findOrFail($request->Cod_Equipo);

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
          ]);

          $image = $request->file('image');

          if($image){

           
            Storage::deleteDirectory('usuarios/equipos/'.$request->Cod_Equipo.'/');
           
            $name =  $unique_name = md5($image->GetClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $message =  'imagen Guardada';

              $path = $request->file('image')->storeAs('usuarios/equipos/'.$request->Cod_Equipo, $name, 'public');
                $complete_path =  '/storage/'.$path;
              
                
      $equipo =  Equipo::where('Cod_Equipo', $request->Cod_Equipo)->update([
              'Foto'=> $complete_path,
              'Avatar'=> false
              
              ]);
       

           return   response()->json([
                'message'=>$message,
                'equipo'=>Equipo::where('Cod_Equipo', $request->Cod_Equipo)->get()
            ]);
          }
         


         

        
    


    }
    public function deleteEquipo(Request $request)
    {
        $equipo = Equipo::where('Cod_Equipo',$request->Cod_Equipo)->delete();
        Storage::deleteDirectory('public/usuarios/canchas/'.$request->Cod_Equipo.'/');
        return response()->json([
            'action'=>true,
            'message'=>'La cancha se borro con exito.',
            'equipo'=>$equipo
        ]);

    }




}
