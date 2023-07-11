<?php

namespace App\Http\Controllers;
use App\Models\UsuarioGeolocalizacion;
use Illuminate\Http\Request;

class UsuariosGeolocalizacion extends Controller
{
  
    public function getUsuarioGeolocalizacion(Request $request){
       
        $geolocalizacion = UsuarioGeolocalizacion::where('Cod_Usuario', $request->Cod_Usuario)->first();
 
        if($geolocalizacion){
            return response([$geolocalizacion], 200);
        }
        return response()->json([], 404); 
    }
    
    public function postUsuarioGeolocalizacion(Request $request)
    {
        $validator = $request->validate([
            'Cod_Usuario'=>'required'
        ]);
        if($validator){
          $geoLocalizacion =  UsuarioGeolocalizacion::create([
                'Cod_Usuario'=>$request->Cod_Usuario,
                'Codigo_Pais'=>$request->Codigo_Pais,
                'Codigo_Estado'=>$request->Codigo_Estado,
                'Codigo_Ciudad'=>$request->Codigo_Ciudad,
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

    public function putUsuarioGeolocalizacion(Request $request)
    {
     
        $geoLocalizacion = UsuarioGeolocalizacion::where('Cod_Usuario', $request->Cod_Usuario)->update([
            'Cod_Usuario'=>$request->Cod_Usuario,
            'Codigo_Pais'=>$request->Codigo_Pais,
            'Codigo_Estado'=>$request->Codigo_Estado,
            'Codigo_Ciudad'=>$request->Codigo_Ciudad,
            'Codigo_Postal'=>$request->Codigo_Postal,
            'Direccion'=>$request->Direccion
            ]);
            if($geoLocalizacion){
                return response()->json([
                    UsuarioGeolocalizacion::where('Cod_Usuario', $request->Cod_Usuario)->first()
                ], 200);
            
            }

            return response()->json([], 404);
    }
   
    public function deleteUsuarioGeocalizacion(Request $request)
    {
      $geoLocalizacion = UsuarioGeolocalizacion::where('Cod_Usuario', $request->Cod_Usuario)->delete();
      if($geoLocalizacion == 1){
        return response()->json([
        ], 200);

      }
      return response()->json([], 404);
    }
 
}
