<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cancha;
use Illuminate\Support\Facades\Storage;
use File;



class Canchas extends Controller
{
  
   

    public function getListaCanchas(){

        $canchas = Cancha::with('provincias','cantones','distritos','categorias','usuarios')->get();
        return    $canchas ;


        if( count($canchas) > 0){

            return   response()->json([
                'cancha'=>Cancha::without('provincias','cantones','distritos','categorias','usuarios')->first(),
                'provincia'=>$canchas->first()->provincias->Provincia,
                'canton'=>$canchas->first()->cantones->Canton,
                'distrito'=>$canchas->first()->distritos->Distrito,
                'categoria'=>$canchas->first()->categorias->Nombre,
                'correo'=>$canchas->first()->usuarios->Correo
            ]);
        }else{

            return  $canchas;
        }
     
    }
    public function getUsuarioCanchas($Cod_Usuario){

        

        $canchas = Cancha::where('Cod_Usuario',  $Cod_Usuario)->with('provincias','cantones','distritos','categorias','usuarios')->get();
         
        $new = [];

        if(count($canchas) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($canchas) ; $i++) {
            array_push($new,
          ['cancha' =>  $canchas[$i]->withoutRelations(), 
          'provincia' => $canchas[$i]->first()->provincias->Provincia,
          'canton' => $canchas[$i]->first()->cantones->Canton,
          'distrito' => $canchas[$i]->first()->distritos->Distrito,
          'categoria' => $canchas[$i]->first()->categorias->Nombre,
          'correo' => $canchas[$i]->first()->usuarios->Correo
          
          
          ]
           );
           if($i == count($canchas) -1){
            return $new;

           }
        
        }
     

      
    }


    public function postCancha(Request $request)
    {

        $validator = $request->validate([
            'Cod_Usuario'=>'required',
            'Cod_Categoria'=>'required',
            'Cod_Provincia'=>'required',
            'Cod_Canton'=>'required',
            'Cod_Distrito'=>'required',
            'Foto'=>'required',
            'Nombre'=>'required',
            'Numero_Cancha'=>'required',
            'Telefono'=>'required',
            'Precio_Hora'=>'required',
            'Luz'=>'required',
            'Precio_Luz'=>'required',
            'Techo'=>'required',
            'Latitud'=>'required',
            'Longitud'=>'required',
            'Estado'=>'required',
            'Descripcion_Estado'=>'required'
        ]);
        if($validator){
          $cancha = Cancha::create([
                'Cod_Usuario'=>$request->Cod_Usuario,
                'Cod_Categoria'=>$request->Cod_Categoria,
                'Cod_Provincia'=>$request->Cod_Provincia,
                'Cod_Canton'=>$request->Cod_Canton,
                'Cod_Distrito'=>$request->Cod_Distrito,
                'Foto'=>$request->Foto,
                'Nombre'=>$request->Nombre,
                'Numero_Cancha'=>$request->Numero_Cancha,
                'Telefono'=>$request->Telefono,
                'Precio_Hora'=>$request->Precio_Hora,
                'Luz'=>$request->Luz,
                'Precio_Luz'=>$request->Precio_Luz,
                'Techo'=>$request->Techo,
                'Latitud'=>$request->Latitud,
                'Longitud'=>$request->Longitud,
                'Estado'=>$request->Estado,
                'Descripcion_Estado'=>$request->Descripcion_Estado
            ]);
          
            return $cancha;
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'cancha'=>$request
            ]);

        }
    }

    public function putCancha(Request $request)
    {



      
    
        $cancha = cancha::where('Cod_Cancha', $request->Cod_Cancha)->update([
            'Cod_Categoria'=>$request->Cod_Categoria,
            'Cod_Provincia'=>$request->Cod_Provincia,
            'Cod_Canton'=>$request->Cod_Canton,
            'Cod_Distrito'=>$request->Cod_Distrito,
            'Nombre'=>$request->Nombre,
            'Numero_Cancha'=>$request->Numero_Cancha,
            'Telefono'=>$request->Telefono,
            'Precio_Hora'=>$request->Precio_Hora,
            'Luz'=>$request->Luz,
            'Precio_Luz'=>$request->Precio_Luz,
            'Techo'=>$request->Techo,
            'Latitud'=>$request->Latitud,
            'Longitud'=>$request->Longitud
            
            ]);

        
            if($cancha){
                return response()->json([
                    'message'=>'La cancha se actualizo con éxito.',
                    'cancha'=>Cancha::where('Cod_Cancha', $request->Cod_Cancha)->get()->first()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'cancha'=>$request
                ]);
            
            }
    }

    public function putEstadoCancha(Request $request)
    {

        $findCancha = Cancha::where('Cod_Cancha', $request->Cod_Cancha)->get()->first();
  
    
     if($findCancha){

        $cancha = cancha::where('Cod_Cancha', $request->Cod_Cancha)->update([
            'Estado'=>!$findCancha->Estado,
            'Descripcion_Estado'=> !$findCancha->Estado ? 'Cancha Activa' :'Cancha Inactiva'
            
            ]);


        
            if($cancha){
                return response()->json([
                    'message'=>'La cancha se actualizo con éxito.',
                    'cancha'=>Cancha::where('Cod_Cancha', $request->Cod_Cancha)->get()->first()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'cancha'=>$request
                ]);
            
            }




     }else{
        return response()->json([
            'message'=>'Lo sentimos algo salio mal.',
            'cancha'=>$request
        ]);
    
    }


    }


    public function postFotoCancha(Request $request)
    {
        $message = "";
        $cancha = Cancha::findOrFail($request->Cod_Cancha);

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
          ]);

          $image = $request->file('image');

          if($image){

           
            Storage::deleteDirectory('usuarios/canchas/'.$request->Cod_Cancha.'/');
           
            $name =  $unique_name = md5($image->GetClientOriginalName(). time()).'.'.$image->getClientOriginalExtension();
            $message =  'imagen Guardada';

              $path = $request->file('image')->storeAs('usuarios/canchas/'.$request->Cod_Cancha, $name, 'public');
                $complete_path =  '/storage/'.$path;
              
                
      $cancha =  cancha::where('Cod_Cancha', $request->Cod_Cancha)->update([
              'Foto'=> $complete_path
              
              ]);
       

           return   response()->json([
                'message'=>$message,
                'cancha'=>Cancha::findOrFail($request->Cod_Cancha)
            ]);
          }
         


         

        
    


    }
    public function deleteCancha(Request $request , $Cod_Cancha)
    {
        $cancha = Cancha::where('Cod_Cancha',$Cod_Cancha)->delete();
        Storage::deleteDirectory('public/usuarios/canchas/'.$request->Cod_Cancha.'/');
      if($cancha == 1){

        return response()->json([
            'action'=>true,
            'message'=>'La cancha se borro con exito.',
            'cancha'=>$cancha
        ]);

      }else{

        return response()->json([
            'action'=>false,
            'message'=>'Error Borrando La Cancha',
            'cancha'=>$cancha
        ]);
    }
    }




}
