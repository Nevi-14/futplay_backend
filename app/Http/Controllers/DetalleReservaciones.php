<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Reservacion;
use App\Models\DetalleReservacion;
use App\Models\HistorialPartido;


class DetalleReservaciones extends Controller
{
  
   


    public function postDetalle(Request $request)
    {
# VALIDA QUE TODOS LOS CAMPOS ESTEN COMPLETOS

        $validator = $request->validate([
            'Cod_Reservacion'=>'required',  
            'Cod_Estado'=>'required',
            'Cod_Retador'=>'required',
            'Cod_Rival'=>'required',
            'Monto_Luz'=>'required',
            'Total_Horas'=>'required',
            'Precio_Hora'=>'required',           
            'Porcentaje_Descuento'=>'required',  
            'Monto_Descuento'=>'required',
            'Porcentaje_Impuesto'=>'required',
            'Monto_Impuesto'=>'required',
            'Porcentaje_FP'=>'required',           
            'Monto_FP'=>'required',  
            'Monto_Equipo'=>'required',
            'Monto_Sub_Total'=>'required',
            'Monto_Total'=>'required',
            'Pendiente'=>'required',
            'Notas_Estado'=>'required'
            
        ]);
        if($validator){

# CREA  DETALLE DE RESERVACION
          $detalle = DetalleReservacion::create([
                'Cod_Reservacion'=>$request->Cod_Reservacion,
                'Reservacion_Grupal'=>$request->Reservacion_Grupal  ? $request->Reservacion_Grupal  : false,
                'Cod_Estado'=>$request->Cod_Estado,
                'Cod_Retador'=>$request->Cod_Retador,
                'Cod_Rival'=>$request->Cod_Rival,
                'Luz'=>$request->Luz,
                'Monto_Luz'=>$request->Monto_Luz,
                'Total_Horas'=>$request->Total_Horas,
                'Precio_Hora'=>$request->Precio_Hora,
                'Cod_Descuento'=>$request->Cod_Descuento,
                'Porcentaje_Descuento'=>$request->Porcentaje_Descuento,
                'Monto_Descuento'=>$request->Monto_Descuento,
                'Porcentaje_Impuesto'=>$request->Porcentaje_Impuesto,
                'Porcentaje_FP'=>$request->Porcentaje_FP,
                'Monto_FP'=>$request->Monto_FP,
                'Monto_Equipo'=>$request->Monto_Equipo,
                'Monto_Sub_Total'=>$request->Monto_Sub_Total,
                'Monto_Total'=>$request->Monto_Total,
                'Pendiente'=>$request->Pendiente,
                'Notas_Estado'=>$request->Notas_Estado,
            ]);
          
            return $detalle;
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'detalle'=>$request
            ]);

        }
    }

    public function putDetalleReservacion(Request $request)
    {

# ACTUALIZA EL DETALLE DE LA RESERVACION

$estado = $request->Cod_Estado ;
if($request->Reservacion_Grupal){

    $estado = $request->Confirmacion_Rival ? 4 : 7;
}

        $detalle = DetalleReservacion::where('Cod_Detalle', $request->Cod_Detalle)->update([
            'Cod_Estado'=> $request->Reservacion_Grupal ? $request->Reservacion_Grupal : false,
            'Cod_Estado'=> $estado,
            'Confirmacion_Rival'=>$request->Confirmacion_Rival,
            'Monto_Sub_Total'=>$request->Monto_Sub_Total,
            'Monto_Total'=>$request->Monto_Total,
            'Pendiente'=>$request->Pendiente,
            'Notas_Estado'=> $request->Confirmacion_Rival ? '' : 'Reservacion Cancelada'
        ]);
            
     
           if($request->Confirmacion_Rival){
# RETADOR
               HistorialPartido::create([
                'Cod_Reservacion'=>$request->Cod_Reservacion,
                'Cod_Equipo'=>$request->Cod_Retador,
                'Evaluacion'=>false,
                'Verificacion_QR'=>false,
                'Goles_Retador'=>0,
                'Goles_Rival'=>0,
                'Estado'=>false
            ]);
# RIVAL
            HistorialPartido::create([
                'Cod_Reservacion'=>$request->Cod_Reservacion,
                'Cod_Equipo'=>$request->Cod_Rival,
                'Evaluacion'=>false,
                'Verificacion_QR'=>false,
                'Goles_Retador'=>0,
                'Goles_Rival'=>0,
                'Estado'=>false
            ]);

           }
        
# ACTUALIZA EL ESTADO DE LA RESERVACION

           Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
            'Cod_Estado'=> $estado
        ]);
           return response()->json([
            'message'=>'La reservacion se actualizo con éxito.',
            'solicitud'=>DetalleReservacion::where('Cod_Detalle', $request->Cod_Detalle)->get()->first()
        ]);
    }

 

    
    public function deleteDetalleReservacion(Request $request)
    {
        Reservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
            'Cod_Estado'=> 7
        ]);
        
        DetalleReservacion::where('Cod_Reservacion', $request->Cod_Reservacion)->update([
            'Cod_Estado'=> 7,
            'Notas_Estado'=> 'Reservacion cancelada'
        ]);


        return response()->json([
            'action'=>true,
            'message'=>'La reservacion se cancelo con exito.',
            'solicitud'=>$solicitud
        ]);

    }




}
