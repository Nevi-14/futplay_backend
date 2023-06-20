<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservacion;
use App\Models\DetalleReservacion;
use Illuminate\Support\Facades\Storage;
use App\Models\Usuario;
use App\Models\Jugador;
use App\mail\email;
use Illuminate\Support\Facades\Mail;
use File;
use DateTime;
use DateInterval;
use Carbon\Carbon;


class Reservaciones extends Controller
{
    public function getTodasReservaciones(Request $request){
        $date = today()->format('Y-m-d');
        $reservaciones =  DetalleReservacion::with('reservaciones','retador','rival')
        ->whereHas('reservaciones', function ($query) use($request){
            $query->whereBetween('Fecha', [$request->Fecha_Inicio, $request->Fecha_Fin])
            ->where('Cod_Cancha', $request->Cod_Cancha);
        })->orderBy('created_at', 'DESC')
        ->get();

        $new = [];

        if(count($reservaciones) == 0){
         

            return $new;
        }
       

    
    for( $i =0; $i < count($reservaciones) ; $i++) {
        array_push($new,
      [
        'usuario' =>  $reservaciones[$i]->retador->usuarios,
        'cancha' =>  $reservaciones[$i]->reservaciones->canchas,
        'reservacion' =>  $reservaciones[$i]->reservaciones, 
      'detalle' =>  $reservaciones[$i]->withoutRelations(),
      'retador' =>  $reservaciones[$i]->retador,
      'rival' =>  $reservaciones[$i]->rival
      
      
      ]
       );
       if($i == count($reservaciones) -1){
        return $new;

       }
    
    }
       
       
        return response()->json($reservaciones);
     
     
     } 
    public function getReservaciones(Request $request){
        $date = today()->format('Y-m-d');
        $reservaciones =  DetalleReservacion::with('reservaciones','retador','rival')
        ->whereHas('reservaciones', function ($query) use($request){
            $query->whereBetween('Fecha', [$request->Fecha_Inicio, $request->Fecha_Fin]);
        })->orderBy('created_at', 'DESC')
        ->get();

        $new = [];

        if(count($reservaciones) == 0){
         

            return $new;
        }
       

    
    for( $i =0; $i < count($reservaciones) ; $i++) {
        array_push($new,
      [
        'usuario' =>  $reservaciones[$i]->retador->usuarios,
        'cancha' =>  $reservaciones[$i]->reservaciones->canchas,
        'reservacion' =>  $reservaciones[$i]->reservaciones, 
      'detalle' =>  $reservaciones[$i]->withoutRelations(),
      'retador' =>  $reservaciones[$i]->retador,
      'rival' =>  $reservaciones[$i]->rival
      
      
      ]
       );
       if($i == count($reservaciones) -1){
        return $new;

       }
    
    }
       
       
        return response()->json($reservaciones);
     
     
     }  
     
     public function getReservacionesUsuario(Request $request){
        $date = today()->format('Y-m-d');
   
       

        $reservaciones =  DetalleReservacion::with('reservaciones','retador','rival')
        ->whereHas('reservaciones', function ($query) use($request){
            $query->whereBetween('Fecha', [$request->Fecha_Inicio, $request->Fecha_Fin])
          ->where('Cod_Usuario', $request->Cod_Usuario)
          ->where('Cod_Cancha', $request->Cod_Cancha);
        })->orderBy('created_at', 'DESC')
        ->get();

        $new = [];

        if(count($reservaciones) == 0){
         

            return $new;
        }
       

    
    for( $i =0; $i < count($reservaciones) ; $i++) {
        array_push($new,
      [
        'usuario' =>  $reservaciones[$i]->retador->usuarios,
        'cancha' =>  $reservaciones[$i]->reservaciones->canchas,
        'reservacion' =>  $reservaciones[$i]->reservaciones, 
      'detalle' =>  $reservaciones[$i]->withoutRelations(),
      'retador' =>  $reservaciones[$i]->retador,
      'rival' =>  $reservaciones[$i]->rival
      
      
      ]
       );
       if($i == count($reservaciones) -1){
        return $new;

       }
    
    }
       
       
        return response()->json($reservaciones);
     
     
     }  
     

    public function getReservacionesCancha(Request $request){
        $date = today()->format('Y-m-d');
   
       

        $reservaciones =  DetalleReservacion::with('reservaciones','retador','rival')
        ->whereHas('reservaciones', function ($query) use($request){
            $query->whereBetween('Fecha', [$request->Fecha_Inicio, $request->Fecha_Fin])
            ->where('Cod_Estado', $request->Cod_Estado)
          ->where('Cod_Cancha', $request->Cod_Cancha);
        })->orderBy('created_at', 'DESC')
        ->get();

        $new = [];

        if(count($reservaciones) == 0){
         

            return $new;
        }
       

    
    for( $i =0; $i < count($reservaciones) ; $i++) {
        array_push($new,
      [
        'usuario' =>  $reservaciones[$i]->retador->usuarios,
        'cancha' =>  $reservaciones[$i]->reservaciones->canchas,
        'reservacion' =>  $reservaciones[$i]->reservaciones, 
      'detalle' =>  $reservaciones[$i]->withoutRelations(),
      'retador' =>  $reservaciones[$i]->retador,
      'rival' =>  $reservaciones[$i]->rival
      
      
      ]
       );
       if($i == count($reservaciones) -1){
        return $new;

       }
    
    }
       
       
        return response()->json($reservaciones);
     
     
     }  
     
   
    public function getReservacionesFuturas(Request $request ){

        $reservaciones = DetalleReservacion::where('Cod_Rival', $request->Cod_Equipo)->orwhere('Cod_Retador', $request->Cod_Equipo) 
        ->where( function ($query)  use($request) {
            $query->whereRelation('reservaciones','Fecha', '>=',$request->Fecha)
           ->whereRelation('reservaciones','Cod_Estado', '!=',2)
          ->whereRelation('reservaciones','Cod_Estado', '!=',7)
          ->whereRelation('reservaciones','Cod_Estado', '!=',8);
        })
        ->get();

        return response()->json($reservaciones);

    }

    public function getReservacionesCanchaDia(Request $request ){

        $reservaciones = Reservacion::where('Cod_Cancha', $request->Cod_Cancha)->where('Fecha', $request->Fecha)
      //->where('Cod_Estado', '!=', 2)
      //->where('Cod_Estado', '!=', 1)
        ->where('Cod_Estado', '!=', 7)
        ->where('Cod_Estado', '!=', 8)
        ->where('Cod_Estado', '!=', 9)
        ->get();

        
        return response()->json($reservaciones);

    


    }
    public function getReservacionesCanchaRango( Request $request){

        $reservaciones =  Reservacion::with('detalles','retador', 'canchas')
             ->whereBetween('Fecha', [$request->Fecha_Inicio, $request->Fecha_Fin])
            ->where('Cod_Cancha', $request->Cod_Cancha)
            ->where('Cod_Estado', '!=', 2)
            ->where('Cod_Estado', '!=', 9)
            ->orderBy('created_at', 'DESC')
        ->get();

        $new = [];

        if(count($reservaciones) == 0){
         

            return $new;
        }
       

    
    for( $i =0; $i < count($reservaciones) ; $i++) {
        array_push($new,
      [
        'usuario' =>  $reservaciones[$i]->retador->usuarios,
        'cancha' =>  $reservaciones[$i]->canchas,
        'reservacion' =>  $reservaciones[$i]->withoutRelations(), 
      'detalle' =>   $reservaciones[$i]->detalles->first() ?  $reservaciones[$i]->detalles->first() : null,
      'retador' =>  $reservaciones[$i]->detalles->first() ?  $reservaciones[$i]->detalles->first()->retador : null,
      'rival' =>  $reservaciones[$i]->detalles->first() ?  $reservaciones[$i]->detalles->first()->rival : null
      
      
      ]
       );
       if($i == count($reservaciones) -1){
        return $new;

       }
    
    }
       
       
        return response()->json($reservaciones);
     

    }
   
    public function getVerificarDisponibilidadReservacion( Request $request){
 
        $dT = new DateTime($request->Hora_Fin);

//Lets subtract 4 hours.
$hoursToSubtract = 1;

//Subtract the hours using DateTime::sub and DateInterval.
$dT->sub(new DateInterval("PT{$hoursToSubtract}H"));

//Format and print it out.
$newTime = $dT->format('Y-m-d H:i');

 
      //  $reservaciones = Reservacion::where('Cod_Cancha', $request->Cod_Cancha)->where('Hora_Inicio','>=', $request->Hora_Inicio )->where('Hora_Fin','<=', $request->Hora_Fin)->get();

   $reservaciones =   Reservacion::where('Cod_Cancha', $request->Cod_Cancha)->whereBetween('Hora_Inicio', [$request->Hora_Inicio, $newTime ])
   ->whereBetween('Hora_Fin', [$request->Hora_Inicio, $newTime ])->get();
        return response()->json($reservaciones);
    }

    public function getReservacionesMovil(Request $request){

       $reservaciones =  DetalleReservacion::with('reservaciones','rival','retador')->whereRelation('retador','Cod_Usuario', $request->Cod_Usuario)
       ->orwhereRelation('rival', 'Cod_Usuario',$request->Cod_Usuario)->get();
      
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
          'titulo' => $reservaciones[$i]->reservaciones->Titulo
          
          ]
           );
           if($i == count($reservaciones) -1){
            return $new;

           }
        
        }
        
    
    
    }  
    

    public function getReservacionesCanceladas(Request $request){
        
        $reservaciones =  [];
        $misEquipos = [];
        $ids =  [];
        $equipos = Jugador::where('Cod_Usuario',  $request->Cod_Usuario)->with('equipos','usuarios')->get();
      
      
        if(count($equipos)  == 0){
            return $reservaciones;
           }
                  for( $e =0; $e < count($equipos) ; $e++) {
        $usuario = $equipos[$e]['equipos']['Cod_Usuario']; 
        $reservacionesEquipos =  DetalleReservacion::with('reservaciones','retador','rival')
        ->where( function ($query) use ($usuario  ) {
            $query->whereRelation('rival','Cod_Usuario', '=', $usuario)
            ->orwhereRelation('retador','Cod_Usuario', '=', $usuario);
        })
        ->WhereHas('reservaciones', function ($query) {
            $query->where('Cod_Estado', '=', 7);
        })
        ->get();
        for( $re =0; $re < count($reservacionesEquipos) ; $re++) {     
            
            
            if(!in_array($reservacionesEquipos[$re]->Cod_Reservacion, $ids))
            {

  array_push($ids,$reservacionesEquipos[$re]->Cod_Reservacion);
  array_push($reservaciones,
              [
               'cancha' => $reservacionesEquipos[$re]->reservaciones->canchas->withoutRelations(),
              'reservacion' =>  $reservacionesEquipos[$re]->reservaciones->withoutRelations(), 
              'detalle' =>  $reservacionesEquipos[$re]->withoutRelations(), 
              'rival' => $reservacionesEquipos[$re]->rival->withoutRelations(),
              'usuario_rival' => $reservacionesEquipos[$re]->rival->usuarios,
              'retador' => $reservacionesEquipos[$re]->retador->withoutRelations(),
              'usuario_retador' => $reservacionesEquipos[$re]->retador->usuarios,
              'categoria' => $reservacionesEquipos[$re]->reservaciones->canchas->categorias->Nombre,
              'correo' => $reservacionesEquipos[$re]->reservaciones->canchas->usuarios->Correo,
              'provincia' => $reservacionesEquipos[$re]->reservaciones->canchas->provincias->Provincia,
              'canton' => $reservacionesEquipos[$re]->reservaciones->canchas->cantones->Canton,
              'distrito' => $reservacionesEquipos[$re]->reservaciones->canchas->distritos->Distrito,
              'titulo' => $reservacionesEquipos[$re]->reservaciones->Titulo     
              ]
               );
  }




          
   

}
        if($e == count($equipos) -1){
            return $reservaciones;
           }
        
        }

         
     }

     public function getReservacionesAbiertas(Request $request){
        
        $reservaciones =  DetalleReservacion::with('reservaciones','rival','retador')
        ->whereRelation('reservaciones', 'Cod_Estado',10)->get();
       
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
           'titulo' => $reservaciones[$i]->reservaciones->Titulo
           
           ]
            );
            if($i == count($reservaciones) -1){
             return $new;
 
            }
         
         }
         
         
     }
     public function getReservacionesCanceladasUsuarios(Request $request){
        $cod_usuario = $request->Cod_Usuario;
        $reservaciones =  DetalleReservacion::with('reservaciones','retador','rival')
        
        ->where( function ($query) use ($cod_usuario ) {
            $query->whereRelation('retador','Cod_Usuario', '=', $cod_usuario)
            ->whereRelation('reservaciones','Cod_Estado', '=', 7);
        })
        ->get();


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
           'titulo' => $reservaciones[$i]->reservaciones->Titulo
           
           
           ]
            );
            if($i == count($reservaciones) -1){
             return $new;
 
            }
         
         }
         
     }
    public function getReservacionesEnviadas(Request $request){
        $reservaciones =  [];
        $misEquipos = [];
        $ids =  [];
        $cod_usuario = $request->Cod_Usuario;
        $equipos = Jugador::where('Cod_Usuario',  $request->Cod_Usuario)->with('equipos','usuarios')->get();
        if(count($equipos)  == 0){
            return $reservaciones;
           }
           
        for( $e =0; $e < count($equipos) ; $e++) {
        $usuario = $equipos[$e]['equipos']['Cod_Usuario']; 
        $reservacionesEquipos =  DetalleReservacion::with('reservaciones','retador','rival')
        ->where( function ($query) use ($cod_usuario, $usuario  ) {
            $query->whereRelation('retador','Cod_Usuario', '=',$usuario)
            ->whereRelation('reservaciones','Cod_Estado', '=', 2);
        })
        ->get();
        for( $re =0; $re < count($reservacionesEquipos) ; $re++) {     
            
            if(!in_array($reservacionesEquipos[$re]->Cod_Reservacion, $ids))
            {

  array_push($ids,$reservacionesEquipos[$re]->Cod_Reservacion);

  array_push($reservaciones,
  [
   'cancha' => $reservacionesEquipos[$re]->reservaciones->canchas->withoutRelations(),
  'reservacion' =>  $reservacionesEquipos[$re]->reservaciones->withoutRelations(), 
  'detalle' =>  $reservacionesEquipos[$re]->withoutRelations(), 
  'rival' => $reservacionesEquipos[$re]->rival->withoutRelations(),
  'usuario_rival' => $reservacionesEquipos[$re]->rival->usuarios,
  'retador' => $reservacionesEquipos[$re]->retador->withoutRelations(),
  'usuario_retador' => $reservacionesEquipos[$re]->retador->usuarios,
  'categoria' => $reservacionesEquipos[$re]->reservaciones->canchas->categorias->Nombre,
  'correo' => $reservacionesEquipos[$re]->reservaciones->canchas->usuarios->Correo,
  'provincia' => $reservacionesEquipos[$re]->reservaciones->canchas->provincias->Provincia,
  'canton' => $reservacionesEquipos[$re]->reservaciones->canchas->cantones->Canton,
  'distrito' => $reservacionesEquipos[$re]->reservaciones->canchas->distritos->Distrito,
  'titulo' => $reservacionesEquipos[$re]->reservaciones->Titulo     
  ]
   );
  }


  
   

}
        if($e == count($equipos) -1){
            return $reservaciones;
           }
        
        }
         
 
         
     }



    public function getReservacionesRecibidas(Request $request){


        $reservaciones =  [];
        $misEquipos = [];
        $ids =  [];
        $cod_usuario = $request->Cod_Usuario;
        $equipos = Jugador::where('Cod_Usuario',  $request->Cod_Usuario)->with('equipos','usuarios')->get();
        if(count($equipos)  == 0){
            return $reservaciones;
           }
           
        for( $e =0; $e < count($equipos) ; $e++) {
        $usuario = $equipos[$e]['equipos']['Cod_Usuario']; 
        $reservacionesEquipos =  DetalleReservacion::with('reservaciones','retador','rival')
        ->where( function ($query) use ($usuario  ) {
            $query->whereRelation('rival','Cod_Usuario', '=',$usuario)
            ->whereRelation('reservaciones','Cod_Estado', '=', 2);
        })
        ->where('Cod_Estado', 3)
        ->get();
        for( $re =0; $re < count($reservacionesEquipos) ; $re++) {         
            if(!in_array($reservacionesEquipos[$re]->Cod_Reservacion, $ids))
            {
                array_push($ids,$reservacionesEquipos[$re]->Cod_Reservacion);

    array_push($reservaciones,
    [
     'cancha' => $reservacionesEquipos[$re]->reservaciones->canchas->withoutRelations(),
    'reservacion' =>  $reservacionesEquipos[$re]->reservaciones->withoutRelations(), 
    'detalle' =>  $reservacionesEquipos[$re]->withoutRelations(), 
    'rival' => $reservacionesEquipos[$re]->rival->withoutRelations(),
    'usuario_rival' => $reservacionesEquipos[$re]->rival->usuarios,
    'retador' => $reservacionesEquipos[$re]->retador->withoutRelations(),
    'usuario_retador' => $reservacionesEquipos[$re]->retador->usuarios,
    'categoria' => $reservacionesEquipos[$re]->reservaciones->canchas->categorias->Nombre,
    'correo' => $reservacionesEquipos[$re]->reservaciones->canchas->usuarios->Correo,
    'provincia' => $reservacionesEquipos[$re]->reservaciones->canchas->provincias->Provincia,
    'canton' => $reservacionesEquipos[$re]->reservaciones->canchas->cantones->Canton,
    'distrito' => $reservacionesEquipos[$re]->reservaciones->canchas->distritos->Distrito,
    'titulo' => $reservacionesEquipos[$re]->reservaciones->Titulo     
    ]
     );


}
   
}
        

if($e == count($equipos) -1){
    return $reservaciones;
   }
        }
         




         
         
     }
     public function getReservacionesHistorial(Request $request){
        $reservaciones =  [];
        $misEquipos = [];
        $ids =  [];
        $equipos = Jugador::where('Cod_Usuario',  $request->Cod_Usuario)->with('equipos','usuarios')->get();
        if(count($equipos)  == 0){
            return $reservaciones;
           }
           
       
       
        for( $e =0; $e < count($equipos) ; $e++) {
        $usuario = $equipos[$e]['equipos']['Cod_Usuario']; 
        $reservacionesEquipos =  DetalleReservacion::with('reservaciones','retador','rival')
        ->where( function ($query) use ($usuario  ) {
            $query->whereRelation('rival','Cod_Usuario', '=', $usuario)
            ->orwhereRelation('retador','Cod_Usuario', '=', $usuario);
        })
        ->WhereHas('reservaciones', function ($query) {
            $query->where('Cod_Estado', '=', 7)
            ->orWhere('Cod_Estado', '=', 6);
        })
        ->get();
        for( $re =0; $re < count($reservacionesEquipos) ; $re++) {
            
            
            if(!in_array($reservacionesEquipos[$re]->Cod_Reservacion, $ids))
            {

  array_push($ids,$reservacionesEquipos[$re]->Cod_Reservacion);
  array_push($reservaciones,
  [
   'cancha' => $reservacionesEquipos[$re]->reservaciones->canchas->withoutRelations(),
  'reservacion' =>  $reservacionesEquipos[$re]->reservaciones->withoutRelations(), 
  'detalle' =>  $reservacionesEquipos[$re]->withoutRelations(), 
  'rival' => $reservacionesEquipos[$re]->rival->withoutRelations(),
  'usuario_rival' => $reservacionesEquipos[$re]->rival->usuarios,
  'retador' => $reservacionesEquipos[$re]->retador->withoutRelations(),
  'usuario_retador' => $reservacionesEquipos[$re]->retador->usuarios,
  'categoria' => $reservacionesEquipos[$re]->reservaciones->canchas->categorias->Nombre,
  'correo' => $reservacionesEquipos[$re]->reservaciones->canchas->usuarios->Correo,
  'provincia' => $reservacionesEquipos[$re]->reservaciones->canchas->provincias->Provincia,
  'canton' => $reservacionesEquipos[$re]->reservaciones->canchas->cantones->Canton,
  'distrito' => $reservacionesEquipos[$re]->reservaciones->canchas->distritos->Distrito,
  'titulo' => $reservacionesEquipos[$re]->reservaciones->Titulo     
  ]
   );
  }




       
   

}
        if($e == count($equipos) -1){
            return $reservaciones;
           }
        
        }
         
     }
     public function  getReservacionesRevision(Request $request){
        $reservaciones =  [];
        $misEquipos = [];
        $ids =  [];
        $equipos = Jugador::where('Cod_Usuario',  $request->Cod_Usuario)->with('equipos','usuarios')->get();
        if(count($equipos)  == 0){
            return $reservaciones;
           }
           
      
        for( $e =0; $e < count($equipos) ; $e++) {
        $usuario = $equipos[$e]['equipos']['Cod_Usuario']; 
        $reservacionesEquipos =  DetalleReservacion::with('reservaciones','retador','rival')
        ->where( function ($query) use ($usuario  ) {
            $query->whereRelation('rival','Cod_Usuario', '=', $usuario)
            ->orwhereRelation('retador','Cod_Usuario', '=', $usuario);
        })
        ->WhereHas('reservaciones', function ($query) {
            $query->where('Cod_Estado', '=', 8);
        })
        ->get();
        for( $re =0; $re < count($reservacionesEquipos) ; $re++) {   
            

            if(!in_array($reservacionesEquipos[$re]->Cod_Reservacion, $ids))
            {

  array_push($ids,$reservacionesEquipos[$re]->Cod_Reservacion);
    array_push($reservaciones,
    [
     'cancha' => $reservacionesEquipos[$re]->reservaciones->canchas->withoutRelations(),
    'reservacion' =>  $reservacionesEquipos[$re]->reservaciones->withoutRelations(), 
    'detalle' =>  $reservacionesEquipos[$re]->withoutRelations(), 
    'rival' => $reservacionesEquipos[$re]->rival->withoutRelations(),
    'usuario_rival' => $reservacionesEquipos[$re]->rival->usuarios,
    'retador' => $reservacionesEquipos[$re]->retador->withoutRelations(),
    'usuario_retador' => $reservacionesEquipos[$re]->retador->usuarios,
    'categoria' => $reservacionesEquipos[$re]->reservaciones->canchas->categorias->Nombre,
    'correo' => $reservacionesEquipos[$re]->reservaciones->canchas->usuarios->Correo,
    'provincia' => $reservacionesEquipos[$re]->reservaciones->canchas->provincias->Provincia,
    'canton' => $reservacionesEquipos[$re]->reservaciones->canchas->cantones->Canton,
    'distrito' => $reservacionesEquipos[$re]->reservaciones->canchas->distritos->Distrito,
    'titulo' => $reservacionesEquipos[$re]->reservaciones->Titulo     
    ]
     );


}



}
        if($e == count($equipos) -1){
            return $reservaciones;
           }
        
        }
     }
     
     public function getReservacionesConfirmadas(Request $request){



        $reservaciones =  [];
        $ids =  [];
        $misEquipos = [];
        $date =  Carbon::now('America/Costa_Rica');
        $newDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)
        ->format('Y-m-d');
        $equipos = Jugador::where('Cod_Usuario',  $request->Cod_Usuario)->with('equipos','usuarios')->get();
       if(count($equipos)  == 0){
        return $reservaciones;
       }
       
        for( $e =0; $e < count($equipos) ; $e++) {
        $usuario = $equipos[$e]['equipos']['Cod_Usuario']; 
        $reservacionesEquipos =  DetalleReservacion::with('reservaciones','retador','rival')
        ->where( function ($query) use ($usuario  ) {
            $query->whereRelation('rival','Cod_Usuario', '=', $usuario)
            ->orwhereRelation('retador','Cod_Usuario', '=', $usuario);
        })
        ->WhereHas('reservaciones', function ($query) use ($newDate) {
            $query->where('Fecha', '>=', $newDate);
        })
        ->WhereHas('reservaciones', function ($query) {
            $query->where('Cod_Estado', '=', 4)
            ->orWhere('Cod_Estado', '=', 5);

        })
        ->get();
        for( $re =0; $re < count($reservacionesEquipos) ; $re++) {         
            if(!in_array($reservacionesEquipos[$re]->Cod_Reservacion, $ids))
            {
                array_push($ids,$reservacionesEquipos[$re]->Cod_Reservacion);
                array_push($reservaciones,
                [
                'Cod_Reservacion'=>$reservacionesEquipos[$re]->reservaciones->withoutRelations()->Cod_Reservacion, 
                 'cancha' => $reservacionesEquipos[$re]->reservaciones->canchas->withoutRelations(),
                'reservacion' =>  $reservacionesEquipos[$re]->reservaciones->withoutRelations(), 
                'detalle' =>  $reservacionesEquipos[$re]->withoutRelations(), 
                'rival' => $reservacionesEquipos[$re]->rival->withoutRelations(),
                'usuario_rival' => $reservacionesEquipos[$re]->rival->usuarios,
                'retador' => $reservacionesEquipos[$re]->retador->withoutRelations(),
                'usuario_retador' => $reservacionesEquipos[$re]->retador->usuarios,
                'categoria' => $reservacionesEquipos[$re]->reservaciones->canchas->categorias->Nombre,
                'correo' => $reservacionesEquipos[$re]->reservaciones->canchas->usuarios->Correo,
                'provincia' => $reservacionesEquipos[$re]->reservaciones->canchas->provincias->Provincia,
                'canton' => $reservacionesEquipos[$re]->reservaciones->canchas->cantones->Canton,
                'distrito' => $reservacionesEquipos[$re]->reservaciones->canchas->distritos->Distrito,
                'titulo' => $reservacionesEquipos[$re]->reservaciones->Titulo     
                ]
                 );
            
            
            }

}
        if($e == count($equipos) -1){
            return $reservaciones;
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

 
      
    
        if($verificar['Cod_Estado'] == 2  || $verificar['Cod_Estado'] == 9  ||  $verificar['Reservacion_Externa']){
          

            Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
                'Cod_Estado'=>9
                
                ]);

DetalleReservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
                    'Cod_Estado'=>9,
                    'Notas_Estado'=> 'Reservacion eliminada'
                    
                    ]);
                    return response()->json([
                        'action'=>true,
                        'message'=>'La reservacion se borro con exito.',
                        'reservacion'=>$request
                    ]);


        }else{
           Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
                'Cod_Estado'=>8
                
                ]);

DetalleReservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
                    'Cod_Estado'=>8,
                    'Notas_Estado'=> 'Reservacion cancelada, pendiente verificacion'
                    
                    ]);
                    return response()->json([
                        'action'=>true,
                        'message'=>'Reservacion cancelada, pendiente verificacion',
                        'reservacion'=> Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->first()
                    ]);

        }

   
    }

   
    public function cancelarReservacion(Request $request)
    {

        $verificar = Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->first();


    
        Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
            'Cod_Estado'=>7
            
            ]);

DetalleReservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
                'Cod_Estado'=>7,
                'Notas_Estado'=> 'Reservacion cancelada, pendiente verificacion'
                
                ]);
                return response()->json([
                    'action'=>true,
                    'message'=>'Reservacion cancelada',
                    'reservacion'=> Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->first()
                ]);

   
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
