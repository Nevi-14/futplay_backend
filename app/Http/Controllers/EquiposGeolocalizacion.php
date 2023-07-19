<?php

namespace App\Http\Controllers;
use App\Models\EquipoGeolocalizacion;
use Illuminate\Http\Request;

class EquiposGeolocalizacion extends Controller
{
  
    public function getEquipoGeolocalizacion(Request $request){
       
        $geolocalizacion = EquipoGeolocalizacion::where('Cod_Equipo', $request->Cod_Equipo)->first();
 
        if($geolocalizacion){
            return response([$geolocalizacion], 200);
        }
        return response()->json([], 404); 
    }
    
    public function postEquipoGeolocalizacion(Request $request)
    {
        $validator = $request->validate([
            'Cod_Equipo'=>'required'
        ]);
        if($validator){
          $geoLocalizacion =  EquipoGeolocalizacion::create([
                'Cod_Equipo'=>$request->Cod_Equipo,
                'Codigo_Pais'=>$request->Codigo_Pais,
                'Pais'=>$request->Pais,
                'Codigo_Estado'=>$request->Codigo_Estado,
                'Estado'=>$request->Estado,
                'Codigo_Ciudad'=>$request->Codigo_Ciudad,
                'Ciudad'=>$request->Ciudad,
                'Codigo_Postal'=>$request->Codigo_Postal,
                'Direccion'=>$request->Direccion
            ]);
          
        if($geoLocalizacion){
            return response()->json([
                $geoLocalizacion 
            ], 200);
        }
        }
        return response()->json([], 404);
    }

    public function putEquipoGeolocalizacion(Request $request)
    {
     
        $geoLocalizacion = EquipoGeolocalizacion::where('Cod_Equipo', $request->Cod_Equipo)->update([
            'Cod_Equipo'=>$request->Cod_Equipo,
            'Codigo_Pais'=>$request->Codigo_Pais,
            'Pais'=>$request->Pais,
            'Codigo_Estado'=>$request->Codigo_Estado,
            'Estado'=>$request->Estado,
            'Codigo_Ciudad'=>$request->Codigo_Ciudad,
            'Ciudad'=>$request->Ciudad,
            'Codigo_Postal'=>$request->Codigo_Postal,
            'Direccion'=>$request->Direccion
            ]);
            if($geoLocalizacion){
                return response()->json([
                    EquipoGeolocalizacion::where('Cod_Equipo', $request->Cod_Equipo)->first()
                ], 200);
            
            }

            return response()->json([], 404);
    }
   
    public function deleteEquipoGeocalizacion(Request $request)
    {
      $geoLocalizacion = EquipoGeolocalizacion::where('Cod_Equipo', $request->Cod_Equipo)->delete();
      if($geoLocalizacion == 1){
        return response()->json([
        ], 200);

      }
      return response()->json([], 404);
    }
 
}
