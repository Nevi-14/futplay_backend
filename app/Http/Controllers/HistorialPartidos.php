<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\HistorialPartido;
use App\Models\Reservacion;
use App\Models\DetalleReservacion;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Usuario;
class HistorialPartidos extends Controller
{
  
   // SOLICITUDES ENVIADAS EQUIPO  Cod_Equipo = Cod_Equipo  && Confirmacion_Equipo = TRUE


    public function getHistorialPartidos($Cod_Reservacion){

        $partido = HistorialPartido::where('Cod_Reservacion',  $Cod_Reservacion)->get();
        return $partido;     

      
    }


    public function postHistorialPartido(Request $request)
    {
    
 

        $validator = $request->validate([  
            'Cod_Reservacion'=>'required',
            'Cod_Equipo'=>'required',
            'Evaluacion'=>'required',
            'Verificacion_QR'=>'required',
            'Goles_Retador'=>'required',
            'Goles_Rival'=>'required',
            'Estado'=>'required'
            
        ]);
        if($validator){
          $partido = HistorialPartido::create([
                'Cod_Reservacion'=>$request->Cod_Reservacion,
                'Cod_Equipo'=>$request->Cod_Equipo,
                'Evaluacion'=>$request->Evaluacion,
                'Verificacion_QR'=>$request->Verificacion_QR,
                'Goles_Retador'=>$request->Goles_Retador,
                'Goles_Rival'=>$request->Goles_Rival,
                'Estado'=>false
            ]);
          
            return $partido;
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'equipo'=>$request
            ]);

        }
    }

    public function putCodigoQR(Request $request)
    {
    

        $reservacion = Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
            'Cod_Estado'=> 5    
            ]);
            DetalleReservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
                'Notas_Estado'=> 'Partido Iniciado'
            ]);
        $validator = $request->validate([  
            'Verificacion_QR'=>'required'
            
        ]);
        if($validator){
          $partido = HistorialPartido::where('Cod_Partido', $request->Cod_Partido)->update([
            'Verificacion_QR'=> $request->Verificacion_QR,
            'Estado'=> true
        ]);
          
   
            //  return response()->json([
          //  HistorialPartido::where('Cod_Reservacion', $request->Cod_Reservacion)->get()
       // ]);
     
       
        return response()->json(
            HistorialPartido::where('Cod_Reservacion', $request->Cod_Reservacion)->get()
        );
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'equipo'=>$request
            ]);

        }
    }
    public function putPartido(Request $request)
    {
    
 

        $validator = $request->validate([  
            'Goles_Retador'=>'required',
            'Goles_Rival'=>'required',
            'Evaluacion'=>'required'
        ]);
        if($validator){
          $partido = HistorialPartido::where('Cod_Partido', $request->Cod_Partido)->update([
            'Goles_Retador'=>$request->Goles_Retador,
            'Goles_Rival'=>$request->Goles_Rival,
            'Evaluacion'=>$request->Evaluacion,
        ]);
          
        return response()->json([
            'message'=>'Partido  Atualizado.',
            'partido'=>HistorialPartido::where('Cod_Reservacion', $request->Cod_Reservacion)->get()
        ]);  
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'equipo'=>$request
            ]);

        }
    }

    public function repararPuntaje(Request $request)
    {
         
        USUARIO::query()->update([
            'Partidos_Jugados'=> 0
        ]);
        EQUIPO::query()->update([
            'ESTRELLAS'=> 1,
            'ESTRELLAS_ANTERIORES'=> 1,
            'DUREZA'=> 0,
            'POSICION_ACTUAL'=> 0,
            'PUNTAJE_ACTUAL'=> 0,
            'PARTIDOS_GANADOS'=> 0,
            'PARTIDOS_PERDIDOS'=> 0,
            'GOLES_FAVOR'=> 0,
            'GOLES_ENCONTRA'=> 0
        ]);
  
        
  $reservaciones = Reservacion::where('Fecha', '<=','2023-03-12')->get();

  
  for($re = 0; $re < count($reservaciones); $re++ ){

    $partido = HistorialPartido::where('Cod_Reservacion', $reservaciones[$re]->Cod_Reservacion)->get();

    
    if(count($partido) > 1 ){

        $partido1  = $partido[0]; # Retador  > Siempre envio el retador como primer registro
        $partido2  = $partido[1]; # Rival    > El rival siempre sera el segundo registro
        
        $jugadores1 =  Jugador::where('Cod_Equipo', $partido[0]->Cod_Equipo)->get();
     
        foreach($jugadores1 as $jugador ){
            Usuario::where('Cod_Usuario', $jugador->Cod_Usuario )->update([
                'Partidos_Jugados'=> $jugador->Partidos_Jugados + 1
            ]); 
        
        
        }
    
        $jugadores2 =  Jugador::where('Cod_Equipo', $partido[1]->Cod_Equipo)->get();
     
        foreach($jugadores2 as $jugador ){
            Usuario::where('Cod_Usuario', $jugador->Cod_Usuario )->update([
                'Partidos_Jugados'=> $jugador->Partidos_Jugados  +1
            ]); 
        
        
        }
      # Una vez que el partido finaliza comparo  confirmo que ambos estados tengan un valor falso y cuando ambos sean falsos cambio el estado de la reservacion y detalle a finalizado 7
      
      Reservacion::where('Cod_Reservacion',  $reservaciones[$re]->Cod_Reservacion)->update([
          'Cod_Estado'=>6
      ]);
      
      
      DetalleReservacion::where('Cod_Reservacion',  $reservaciones[$re]->Cod_Reservacion)->update([
          'Cod_Estado'=>6,
          'Notas_Estado' => 'Partido Finalizado'
      ]);
      
      
       
        # Asignar puntaje a los equipos
      
      $retador = Equipo::where('Cod_Equipo', $partido1['Cod_Equipo'])->get(); 
      $rival = Equipo::where('Cod_Equipo', $partido2['Cod_Equipo'])->get(); 
      
       
      $estrellasAnterioresRetador = $retador[0]['Estrellas_Anteriores'];
      $estrellasAnterioresRival = $rival[0]['Estrellas_Anteriores'];
      
      $estrellasRetador = $retador[0]['Estrellas'];
      $estrellasRival = $rival[0]['Estrellas'];
      
      $partidosGandosRetador = $retador[0]['Partidos_Ganados'];
      $partidosGanadoslRival = $rival[0]['Partidos_Ganados'];
      
      
      $partidosPerdisosRetador = $retador[0]['Partidos_Perdidos'];
      $partidosPerdidosRival = $rival[0]['Partidos_Perdidos'];
      
      
      $golesFavorRetador = $retador[0]['Goles_Favor'];
      $golesFavorRival = $rival[0]['Goles_Favor'];
      
      
      
      $golesEncontraRetador = $retador[0]['Goles_Encontra'];
      $golesEncontraRival = $rival[0]['Goles_Encontra'];
      
      
      $puntajeActualRetador = $retador[0]['Puntaje_Actual'];
      $puntakeActualRival = $rival[0]['Puntaje_Actual'];
      
      
      
      # Logica asignacion de puntos * estrellas del equipo  * 10
      # cada vez que un equipo gana aumenta una estrella  minimo 1 max 5 
      # Puntos  Ganar = 3 puntos
      # Puntos  Empate = 1 punto
      # Puntos  Perder = 0 puntos
       
      if($partido1['Goles_Retador'] > $partido1['Goles_Rival'] && !$partido1['Estado']  && !$partido2['Estado']   ){
    
      
          $puntos = $estrellasRival  * 3 * 10;
          
          # Gano el Retador aumenta 1 estrella , Pierde Rival pierde 1 estrella
          # Retador
          $Cod_Retador = $partido1['Cod_Equipo'];
          $Cod_Rival = $partido2['Cod_Equipo'];
          Equipo::where('Cod_Equipo', $partido1['Cod_Equipo'] )->update([
              'Estrellas_Anteriores'=>  $estrellasRetador,
              'Estrellas'=> $estrellasRetador+1  >= 5 ? 5 :  $estrellasRetador + 1,
              'Puntaje_Actual'=>  $puntajeActualRetador  + $puntos,
              'Partidos_Ganados'=>  $partidosGandosRetador + 1,
              'Partidos_Perdidos'=>  $partidosPerdisosRetador,
              'Goles_Favor'=>  $golesFavorRetador + $partido1['Goles_Retador'],
              'Goles_Encontra'=>  $golesEncontraRetador + $partido1['Goles_Rival']
          ]);
      
        
      
          # Rival
          Equipo::where('Cod_Equipo', $partido2['Cod_Equipo'])->update([
              'Estrellas_Anteriores'=>  $estrellasRival,
              'Estrellas'=>  $estrellasRival == 1 ? 1 :  $estrellasRival - 1,
              'Puntaje_Actual'=>  $puntakeActualRival,
              'Partidos_Ganados'=>  $partidosGanadoslRival,
              'Partidos_Perdidos'=>  $partidosPerdidosRival + 1,
              'Goles_Favor'=>  $golesFavorRival,
              'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Rival'],
              'Goles_Encontra'=>  $golesEncontraRival +  $partido1['Goles_Retador']
          ]);
      
       
      
      }else if($partido1['Goles_Retador'] < $partido1['Goles_Rival']  && !$partido1['Estado']  && !$partido2['Estado'] ){
        # Gano el Rival  aumenta 1 estrella , Pierde Retador pierde 1 estrella
        $puntos = $estrellasRetador  * 3 * 10;
        $Cod_Retador = $partido1['Cod_Equipo'];
        $Cod_Rival = $partido2['Cod_Equipo'];
        
          # Rival
          Equipo::where('Cod_Equipo', $partido2['Cod_Equipo'])->update([
              'Estrellas_Anteriores'=>  $estrellasRival,
              'Estrellas'=>  $estrellasRival+1 >= 5 ? 5 :  $estrellasRival +  1,
              'Puntaje_Actual'=>  $puntakeActualRival  + $puntos,
              'Partidos_Ganados'=>  $partidosGanadoslRival + 1,
              'Partidos_Perdidos'=>  $partidosPerdidosRival,
              'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Retador'],
              'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Rival'],
              'Goles_Encontra'=>  $golesEncontraRival + $partido1['Goles_Retador']
          ]);
      
          # Retador
          Equipo::where('Cod_Equipo', $partido1['Cod_Equipo'] )->update([
              'Estrellas_Anteriores'=>  $estrellasRetador,
              'Estrellas'=>  $estrellasRetador  == 1 ? 1 :  $estrellasRetador - 1,
              'Puntaje_Actual'=>  $puntajeActualRetador,
              'Partidos_Ganados'=>  $partidosGandosRetador ,
              'Partidos_Perdidos'=>  $partidosPerdisosRetador + 1,
              'Goles_Favor'=>  $golesFavorRetador,
              'Goles_Favor'=>  $golesFavorRetador + $partido1['Goles_Retador'],
              'Goles_Encontra'=>  $golesEncontraRetador + $partido1['Goles_Rival']
          ]);
      
      
      
      
      }else if ($partido1['Goles_Retador'] == $partido1['Goles_Rival'] && !$partido1['Estado']  && !$partido2['Estado'] ){
      
          $Cod_Retador = $partido1['Cod_Equipo'];
          $Cod_Rival = $partido2['Cod_Equipo'];
          $puntosRetador = $estrellasRival  * 1 * 10;
          $puntosRival = $estrellasRetador  * 1 * 10;
          # Rival
          Equipo::where('Cod_Equipo', $partido2['Cod_Equipo'])->update([
              'Estrellas_Anteriores'=>  $estrellasRival,
              'Estrellas'=>  $estrellasRival,
              'Puntaje_Actual'=>  $puntakeActualRival  + $puntosRetador,
              'Partidos_Ganados'=>  $partidosGanadoslRival,
              'Partidos_Perdidos'=>  $partidosPerdidosRival,
              'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Rival'],
              'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Rival'],
              'Goles_Encontra'=>  $golesEncontraRival + $partido1['Goles_Retador']
          ]);
      
          # Retador
          Equipo::where('Cod_Equipo', $partido1['Cod_Equipo'] )->update([
              'Estrellas_Anteriores'=>  $estrellasRetador,
              'Estrellas'=>  $estrellasRetador,
              'Puntaje_Actual'=>  $puntajeActualRetador + $puntosRival,
              'Partidos_Ganados'=>  $partidosGandosRetador,
              'Partidos_Perdidos'=>  $partidosPerdisosRetador,
              'Goles_Favor'=>  $golesFavorRetador + $partido1['Goles_Retador'],
              'Goles_Encontra'=>  $golesEncontraRetador + $partido1['Goles_Rival']
          ]);
      
      
      
      }
      HistorialPartido::where('Cod_Reservacion', $reservaciones[$re]->Cod_Reservacion)->update([
        'Estado'=>false
    ]);
      
      $equipos = Equipo::orderBy('Puntaje_Actual','DESC')->get();
      $count = 0;
    
      for($e =0; $e < count($equipos); $e ++){
          $count = $count + 1;
          Equipo::where('Cod_Equipo', $equipos[$e]->Cod_Equipo )->update([
              'Posicion_Actual'=> $count
          ]);
      
      
      
      }
      
      
    
    
    }
    
    







    if($re == count($reservaciones) - 1){

        return response()->json([
            'message'=>'PUNTAJES ACTUALIZADOS'
        ]);
    }
  }
  



    }
   
    public function finalizarPartido(Request $request)
    {
        
    
               
            HistorialPartido::where('Cod_Partido', $request->Cod_Partido)->update([
            'Goles_Retador'=>$request->Goles_Retador,
            'Goles_Rival'=>$request->Goles_Rival,
            'Estado'=>false,
        ]);

  $partido = HistorialPartido::where('Cod_Reservacion', $request->Cod_Reservacion)->get();

  $partido1  = $partido[0]; # Retador  > Siempre envio el retador como primer registro
  $partido2  = $partido[1]; # Rival    > El rival siempre sera el segundo registro
  
# Una vez que el partido finaliza comparo  confirmo que ambos estados tengan un valor falso y cuando ambos sean falsos cambio el estado de la reservacion y detalle a finalizado 7

  if(!$partido1['Estado'] && !$partido2['Estado']){

    Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
        'Cod_Estado'=>6
    ]);

    
    DetalleReservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
        'Cod_Estado'=>6,
        'Notas_Estado' => 'Partido Finalizado'
    ]);
    
   
  }
  $jugadores =  Jugador::where('Cod_Equipo', $request->Cod_Equipo)->get();
 
  foreach($jugadores as $jugador ){
      Usuario::where('Cod_Usuario', $jugador->Cod_Usuario )->update([
  
          'Partidos_Jugados'=> $jugador->Partidos_Jugados  +1
      ]); 
  
  
  }
  # Asignar puntaje a los equipos

$retador = Equipo::where('Cod_Equipo', $partido1['Cod_Equipo'])->get(); 
$rival = Equipo::where('Cod_Equipo', $partido2['Cod_Equipo'])->get(); 

 
$estrellasAnterioresRetador = $retador[0]['Estrellas_Anteriores'];
$estrellasAnterioresRival = $rival[0]['Estrellas_Anteriores'];

$estrellasRetador = $retador[0]['Estrellas'];
$estrellasRival = $rival[0]['Estrellas'];

$partidosGandosRetador = $retador[0]['Partidos_Ganados'];
$partidosGanadoslRival = $rival[0]['Partidos_Ganados'];


$partidosPerdisosRetador = $retador[0]['Partidos_Perdidos'];
$partidosPerdidosRival = $rival[0]['Partidos_Perdidos'];


$golesFavorRetador = $retador[0]['Goles_Favor'];
$golesFavorRival = $rival[0]['Goles_Favor'];



$golesEncontraRetador = $retador[0]['Goles_Encontra'];
$golesEncontraRival = $rival[0]['Goles_Encontra'];


$puntajeActualRetador = $retador[0]['Puntaje_Actual'];
$puntakeActualRival = $rival[0]['Puntaje_Actual'];



# Logica asignacion de puntos * estrellas del equipo  * 10
# cada vez que un equipo gana aumenta una estrella  minimo 1 max 5 
# Puntos  Ganar = 3 puntos
# Puntos  Empate = 1 punto
# Puntos  Perder = 0 puntos
 
if($partido1['Goles_Retador'] > $partido1['Goles_Rival'] && !$partido1['Estado']  && !$partido2['Estado']   ){

    $puntos = $estrellasRival  * 3 * 10;
    
    # Gano el Retador aumenta 1 estrella , Pierde Rival pierde 1 estrella
    # Retador
    $Cod_Retador = $partido1['Cod_Equipo'];
    $Cod_Rival = $partido2['Cod_Equipo'];
    Equipo::where('Cod_Equipo', $partido1['Cod_Equipo'] )->update([
        'Estrellas_Anteriores'=>  $estrellasRetador,
        'Estrellas'=> $estrellasRetador+1  >= 5 ? 5 :  $estrellasRetador + 1,
        'Puntaje_Actual'=>  $puntajeActualRetador  + $puntos,
        'Partidos_Ganados'=>  $partidosGandosRetador + 1,
        'Partidos_Perdidos'=>  $partidosPerdisosRetador,
        'Goles_Favor'=>  $golesFavorRetador + $partido1['Goles_Retador'],
        'Goles_Encontra'=>  $golesEncontraRetador + $partido1['Goles_Rival']
    ]);



    # Rival
    Equipo::where('Cod_Equipo', $partido2['Cod_Equipo'])->update([
        'Estrellas_Anteriores'=>  $estrellasRival,
        'Estrellas'=>  $estrellasRival == 1 ? 1 :  $estrellasRival - 1,
        'Puntaje_Actual'=>  $puntakeActualRival,
        'Partidos_Ganados'=>  $partidosGanadoslRival,
        'Partidos_Perdidos'=>  $partidosPerdidosRival + 1,
        'Goles_Favor'=>  $golesFavorRival,
        'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Rival'],
        'Goles_Encontra'=>  $golesEncontraRival +  $partido1['Goles_Retador']
    ]);

}else if($partido1['Goles_Retador'] < $partido1['Goles_Rival']  && !$partido1['Estado']  && !$partido2['Estado'] ){
  # Gano el Rival  aumenta 1 estrella , Pierde Retador pierde 1 estrella
  $puntos = $estrellasRetador  * 3 * 10;
  $Cod_Retador = $partido1['Cod_Equipo'];
  $Cod_Rival = $partido2['Cod_Equipo'];
  
    # Rival
    Equipo::where('Cod_Equipo', $partido2['Cod_Equipo'])->update([
        'Estrellas_Anteriores'=>  $estrellasRival,
        'Estrellas'=>  $estrellasRival+1 >= 5 ? 5 :  $estrellasRival +  1,
        'Puntaje_Actual'=>  $puntakeActualRival  + $puntos,
        'Partidos_Ganados'=>  $partidosGanadoslRival + 1,
        'Partidos_Perdidos'=>  $partidosPerdidosRival,
        'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Retador'],
        'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Rival'],
        'Goles_Encontra'=>  $golesEncontraRival + $partido1['Goles_Retador']
    ]);

    # Retador
    Equipo::where('Cod_Equipo', $partido1['Cod_Equipo'] )->update([
        'Estrellas_Anteriores'=>  $estrellasRetador,
        'Estrellas'=>  $estrellasRetador  == 1 ? 1 :  $estrellasRetador - 1,
        'Puntaje_Actual'=>  $puntajeActualRetador,
        'Partidos_Ganados'=>  $partidosGandosRetador ,
        'Partidos_Perdidos'=>  $partidosPerdisosRetador + 1,
        'Goles_Favor'=>  $golesFavorRetador,
        'Goles_Favor'=>  $golesFavorRetador + $partido1['Goles_Retador'],
        'Goles_Encontra'=>  $golesEncontraRetador + $partido1['Goles_Rival']
    ]);



}else if ($partido1['Goles_Retador'] == $partido1['Goles_Rival'] && !$partido1['Estado']  && !$partido2['Estado'] ){

    $Cod_Retador = $partido1['Cod_Equipo'];
    $Cod_Rival = $partido2['Cod_Equipo'];
    $puntosRetador = $estrellasRival  * 1 * 10;
    $puntosRival = $estrellasRetador  * 1 * 10;
    # Rival
    Equipo::where('Cod_Equipo', $partido2['Cod_Equipo'])->update([
        'Estrellas_Anteriores'=>  $estrellasRival,
        'Estrellas'=>  $estrellasRival,
        'Puntaje_Actual'=>  $puntakeActualRival  + $puntosRetador,
        'Partidos_Ganados'=>  $partidosGanadoslRival,
        'Partidos_Perdidos'=>  $partidosPerdidosRival,
        'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Rival'],
        'Goles_Favor'=>  $golesFavorRival + $partido1['Goles_Rival'],
        'Goles_Encontra'=>  $golesEncontraRival + $partido1['Goles_Retador']
    ]);

    # Retador
    Equipo::where('Cod_Equipo', $partido1['Cod_Equipo'] )->update([
        'Estrellas_Anteriores'=>  $estrellasRetador,
        'Estrellas'=>  $estrellasRetador,
        'Puntaje_Actual'=>  $puntajeActualRetador + $puntosRival,
        'Partidos_Ganados'=>  $partidosGandosRetador,
        'Partidos_Perdidos'=>  $partidosPerdisosRetador,
        'Goles_Favor'=>  $golesFavorRetador + $partido1['Goles_Retador'],
        'Goles_Encontra'=>  $golesEncontraRetador + $partido1['Goles_Rival']
    ]);

    # Gano el Retador aumenta 1 estrella , Pierde Rival pierde 1 estrella


        # Gano el Retador aumenta 1 estrella , Pierde Rival pierde 1 estrella
     

}


$equipos = Equipo::orderBy('Puntaje_Actual','DESC')->get();
$count = 0;

for($e =0; $e < count($equipos); $e ++){
    $count = $count + 1;
    Equipo::where('Cod_Equipo', $equipos[$e]->Cod_Equipo )->update([
        'Posicion_Actual'=> $count
    ]);



}

return response()->json([
    'message'=>'Partido Finalizado',
    'partido'=> HistorialPartido::where('Cod_Reservacion', $request->Cod_Reservacion)->get()
]);



    }


}
