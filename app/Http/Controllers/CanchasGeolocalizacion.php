<?php

namespace App\Http\Controllers;
use App\Models\CanchaGeolocalizacion;
use Illuminate\Http\Request;

class EquiposGeolocalizacion extends Controller
{
  
    public function getCanchaGeolocalizacion(Request $request){
       
        $geolocalizacion = CanchaGeolocalizacion::where('Cod_Cancha', $request->Cod_Cancha)->first();
 
        if($geolocalizacion){
            return response([$geolocalizacion], 200);
        }
        return response()->json([], 404); 
    }
    
    public function postCanchaGeolocalizacion(Request $request)
    {
        $validator = $request->validate([
            'Cod_Cancha'=>'required'
        ]);
        if($validator){
          $geoLocalizacion =  CanchaGeolocalizacion::create([
                'Cod_Cancha'=>$request->Cod_Cancha,
                'Codigo_Pais'=>$request->Codigo_Pais,
                'Pais'=>$request->Pais,
                'Codigo_Estado'=>$request->Codigo_Estado,
                'Estado'=>$request->Estado,
                'Codigo_Ciudad'=>$request->Codigo_Ciudad,
                'Ciudad'=>$request->Ciudad,
                'Codigo_Postal'=>$request->Codigo_Postal,
                'Direccion'=>$request->Direccion,
                'Latitud'=>$request->Latitud,
                'Longitud'=>$request->Longitud
            ]);
          
        if($geoLocalizacion){
            return response()->json([
                $geoLocalizacion 
            ], 200);
        }
        }
        return response()->json([], 404);
    }

    public function putCanchaGeolocalizacion(Request $request)
    {
     
        $geoLocalizacion = CanchaGeolocalizacion::where('Cod_Cancha', $request->Cod_Cancha)->update([
            'Cod_Cancha'=>$request->Cod_Cancha,
            'Codigo_Pais'=>$request->Codigo_Pais,
            'Pais'=>$request->Pais,
            'Codigo_Estado'=>$request->Codigo_Estado,
            'Estado'=>$request->Estado,
            'Codigo_Ciudad'=>$request->Codigo_Ciudad,
            'Ciudad'=>$request->Ciudad,
            'Codigo_Postal'=>$request->Codigo_Postal,
            'Direccion'=>$request->Direccion,
            'Latitud'=>$request->Latitud,
            'Longitud'=>$request->Longitud
            ]);
            if($geoLocalizacion){
                return response()->json([
                    CanchaGeolocalizacion::where('Cod_Cancha', $request->Cod_Cancha)->first()
                ], 200);
            
            }

            return response()->json([], 404);
    }
   
    public function deleteCanchaGeocalizacion(Request $request)
    {
      $geoLocalizacion = CanchaGeolocalizacion::where('Cod_Cancha', $request->Cod_Cancha)->delete();
      if($geoLocalizacion == 1){
        return response()->json([
        ], 200);

      }
      return response()->json([], 404);
    }
 
}
