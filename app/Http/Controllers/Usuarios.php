<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\mail\email;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordReset;
class Usuarios extends Controller
{
  
   

    public function getUsers(Request $request){
 
        $usuarios = Usuario::with('provincias','cantones','distritos', 'posiciones')->where('Cod_Usuario','!=' , $request->Cod_Usuario)->get();

        $new = [];

        if(count($usuarios) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($usuarios) ; $i++) {
            array_push($new,
          [
            'nombre' =>  $usuarios[$i]->Nombre .' '. $usuarios[$i]->Primer_Apellido, 
            'usuario' =>  $usuarios[$i]->withoutRelations(), 
          'provincia' => $usuarios[$i]->provincias->Provincia,
          'canton' => $usuarios[$i]->cantones->Canton,
          'distrito' => $usuarios[$i]->distritos->Distrito,
          'posicion' => $usuarios[$i]->posiciones->Posicion
        
          
          
          ]
           );
           if($i == count($usuarios) -1){
            return $new;

           }
        
        }


       
    }


    public function getFiltroUsuarios(Request $request){

        $usuarios =   [];
       

     
      
        if($request->Cod_Posicion != 'null' ){



            if ($request->Cod_Provincia != 'null'  && $request->Cod_Canton  != 'null'  && $request->Cod_Distrito  != 'null' && $request->Cod_Posicion != 'null' ){
            
                $usuarios =  Usuario::with('provincias','cantones','distritos', 'posiciones')
                ->whereRelation('provincias','Cod_Provincia', $request->Cod_Provincia)
                ->whereRelation('cantones','Cod_Canton', $request->Cod_Canton)
                ->whereRelation('distritos','Cod_Distrito',$request->Cod_Distrito)
                ->Where('Cod_Posicion', $request->Cod_Posicion)
                ->Where('Estado', 1)->get();
                
            }else if ($request->Cod_Provincia != 'null'  && $request->Cod_Canton != 'null'  && $request->Cod_Posicion != 'null'){
            
                $usuarios =  Usuario::with('provincias','cantones','distritos', 'posiciones')
                ->whereRelation('provincias','Cod_Provincia', $request->Cod_Provincia)
                ->whereRelation('cantones','Cod_Canton', $request->Cod_Canton)
                ->Where('Cod_Posicion', $request->Cod_Posicion)
                ->Where('Estado', 1)->get();
            
            }

            else  if($request->Cod_Provincia  != 'null' && $request->Cod_Posicion != 'null'){


            
                $usuarios =  Usuario::with('provincias','cantones','distritos', 'posiciones')
                ->whereRelation('provincias','Cod_Provincia', $request->Cod_Provincia)
                ->Where('Cod_Posicion', $request->Cod_Posicion)
                ->Where('Estado', 1)->get();
            } 
            

        }else{


            if ($request->Cod_Provincia  != 'null' && $request->Cod_Canton  != 'null'  && $request->Cod_Distrito  != 'null'){
            
                $usuarios =  Usuario::with('provincias','cantones','distritos', 'posiciones')
                ->whereRelation('provincias','Cod_Provincia', $request->Cod_Provincia)
                ->whereRelation('cantones','Cod_Canton', $request->Cod_Canton)
                ->whereRelation('distritos','Cod_Distrito',$request->Cod_Distrito)
                ->Where('Estado', 1)->get();
                
            }else if ($request->Cod_Provincia  != 'null' && $request->Cod_Canton  != 'null'){
            
                $usuarios =  Usuario::with('provincias','cantones','distritos', 'posiciones')
                ->whereRelation('provincias','Cod_Provincia', $request->Cod_Provincia)
                ->whereRelation('cantones','Cod_Canton', $request->Cod_Canton)
                ->Where('Estado', 1)->get();
            
            }else  if($request->Cod_Provincia  != 'null'){

                $usuarios =  Usuario::with('provincias','cantones','distritos', 'posiciones')
                ->whereRelation('provincias','Cod_Provincia', $request->Cod_Provincia)
                ->Where('Estado', 1)->get();
            } 
            


        }


       
        $new = [];

        if(count($usuarios) == 0){
         

            return $new;
        }
        for( $i =0; $i < count($usuarios) ; $i++) {
            array_push($new,
          [
            'nombre' =>  $usuarios[$i]->Nombre .' '. $usuarios[$i]->Primer_Apellido,
            'usuario' =>  $usuarios[$i]->withoutRelations(), 
          'provincia' => $usuarios[$i]->provincias->Provincia,
          'canton' => $usuarios[$i]->cantones->Canton,
          'distrito' => $usuarios[$i]->distritos->Distrito,
          'posicion' => $usuarios[$i]->posiciones->Posicion
        
          
          
          ]
           );
           if($i == count($usuarios) -1){
            return $new;

           }
        
        }
     
    }



    public function login($value){

        $user = Usuario::where('Correo', $value)->orWhere('Telefono', $value)->first();
        return $user->makeVisible(['Contrasena']); 
    }

    public function loginMovil($value){

        $user = Usuario::with('provincias','cantones','distritos', 'posiciones')->where('Correo', $value)->orWhere('Telefono', $value)->first();
         
        if($user){
            return response()->json([
                'action'=>true,
                'message'=>'Bienvenido',
                'nombre' =>  $user->Nombre .' '. $user->Primer_Apellido,
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
    public function deleteUser(Request $request)
    {
        $user = Usuario::where('Cod_Usuario',$request->Cod_Usuario)->delete();
        return response()->json([
            'message'=>'El usuario se borro con exito.',
            'user'=>$user
        ]);
    }

    public function postUser(Request $request)
    {

        $validator = $request->validate([
            'Cod_Role'=>'required',
            'Cod_Posicion'=>'required',
            'Cod_Provincia'=>'required',
            'Cod_Canton'=>'required',
            'Cod_Distrito'=>'required',
            'Nombre'=>'required',
            'Primer_Apellido'=>'required',
            'Fecha_Nacimiento'=>'required',
            'Telefono'=>'required',
            'Correo'=>'required',
            'Contrasena'=>'required'
        ]);
        if($validator){
            Usuario::create([
                'Cod_Role'=>$request->Cod_Role,
                'Cod_Posicion'=>$request->Cod_Posicion,
                'Cod_Provincia'=>$request->Cod_Provincia,
                'Cod_Canton'=>$request->Cod_Canton,
                'Cod_Distrito'=>$request->Cod_Distrito,
                'Nombre'=>$request->Nombre,
                'Primer_Apellido'=>$request->Primer_Apellido,
                'Fecha_Nacimiento'=>$request->Fecha_Nacimiento,
                'Telefono'=>$request->Telefono,
                'Correo'=>$request->Correo,
                'Contrasena'=>$request->Contrasena
            ]);
          
        $user = Usuario::with('provincias','cantones','distritos', 'posiciones')->where('Correo', $request->Correo)->first();
         
        if($user){
            return response()->json([
                'action'=>true,
                'message'=>'Bienvenido',
                'nombre' =>  $user->Nombre .' '. $user->Primer_Apellido,
                'usuario'=>$user->makeVisible(['Contrasena'])->withoutRelations(),
                'provincia'=>$user->provincias->Provincia,
                'canton'=>$user->cantones->Canton,
                'distrito'=>$user->distritos->Distrito,
                'posicion'=>$user->posiciones->Posicion,
            ]);

        }


            return $user;
        }else{
            return response()->json([
                'message'=>'Lo sentimos algo salio mal.',
                'user'=>$request
            ]);

        }
    }

    public function putUser(Request $request)
    {
     
        $user = Usuario::where('Cod_Usuario', $request->Cod_Usuario)->update([
            'Cod_Posicion'=>$request->Cod_Posicion,
            'Cod_Provincia'=>$request->Cod_Provincia,
            'Cod_Canton'=>$request->Cod_Canton,
            'Cod_Distrito'=>$request->Cod_Distrito,
            'Nombre'=>$request->Nombre,
            'Estatura'=>$request->Estatura,
            'Primer_Apellido'=>$request->Primer_Apellido,
            'Segundo_Apellido'=>$request->Segundo_Apellido,
            'Fecha_Nacimiento'=>$request->Fecha_Nacimiento,
            'Peso'=>$request->Peso,
            'Apodo'=>$request->Apodo
            ]);

        
            if($user){
                return response()->json([
                    'message'=>'El usuario se actualizo con éxito.',
                    'user'=>Usuario::where('Cod_Usuario', $request->Cod_Usuario)->get()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'user'=>$user
                ]);
            
            }
    }

    public function putJugadorFutPlay(Request $request)
    {
        $usuario = Usuario::where('Cod_Usuario', $request->Cod_Usuario)->first();
         Usuario::where('Cod_Usuario', $request->Cod_Usuario)->update([
            'Partidos_Jugador_Futplay'=> $usuario['Partidos_Jugador_Futplay'] + 1
            ]);

        
            return response()->json([
                'message'=>'El usuarioddd se actualizo con éxito.',
                'user'=>Usuario::where('Cod_Usuario', $request->Cod_Usuario)->get()->first()
            ]);
    }

    public function putJugadorDelPartido(Request $request)
    {
        $usuario = Usuario::where('Cod_Usuario', $request->Cod_Usuario)->first();
         Usuario::where('Cod_Usuario', $request->Cod_Usuario)->update([
            'Partidos_Jugador_Del_Partido'=>$usuario['Partidos_Jugador_Del_Partido'] + 1
            ]);

        
            return response()->json([
                'message'=>'El usuario se actualizo con éxito.',
                'user'=>Usuario::where('Cod_Usuario', $request->Cod_Usuario)->get()->first()
            ]);
    }



    public function forgotPassword(Request $request)
    {
   
    $email =  $request->body['email'];
    $token = $request->body['token'];
    $body =  'Codigo de seguridad de verificación de cambio de contraseña, utilice el siguiente codigo '. $token;
    $footer = 'Gracias';
    $user = Usuario::where('Correo', $email)->orWhere('Telefono', $email)->get()->first();
   
   if($user){

    $name = $user->Nombre;
    Mail::to($user->Correo)->send(new email($name,$body, $footer ));
    PasswordReset::create([
        'email'=> $user->Correo,
        'token'=>$token,
    ]);
    return response()->json([
        'message'=>'Se ha enviado un codigo de seguridad al correo',
        
    ]);
   } else{
    return response()->json([
        'message'=>'Lo sentimos algo salio mal.'
    ]);
   }


    }





    public function putUserAvatar(Request $request)
    {
     
        $user = Usuario::where('Cod_Usuario', $request->Cod_Usuario)->update([
            'Avatar'=>$request->Avatar,
            'Foto'=>$request->Foto
            ]);

        
            if($user){
                return response()->json([
                    'message'=>'El usuario se actualizo con éxito.',
                    'usuario'=>Usuario::where('Cod_Usuario', $request->Cod_Usuario)->get()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'usuario'=>$user
                ]);
            
            }
    }
    public function postFotoUsuario(Request $request)
    {

     
       
        $message = "";
        $usuario = Usuario::findOrFail($request->Cod_Usuario);
        
       
       
          $image = $request->file('image');

      
           
            Storage::deleteDirectory('usuarios/perfil/'.$request->Cod_Usuario.'/');
           
            $name =  $unique_name = md5($image->GetClientOriginalName().time()).'.'.$image->getClientOriginalExtension();
            $message =  'imagen Guardada';

         
              $path = $request->file('image')->storeAs('usuarios/perfil/'.$usuario->Cod_Usuario, $name, 'public');
                $complete_path =  '/storage/'.$path;
                if($image){
                 
                
      $usuario =  Usuario::where('Cod_Usuario', $request->Cod_Usuario)->update([
              'Foto'=> $complete_path,
              'Avatar'=> false
              
              ]);
       

           return   response()->json([
                'message'=>$message,
                'usuario'=>Usuario::findOrFail($request->Cod_Usuario)
            ]);
          }
         


         

        
    


    }

    public function putUserPassword(Request $request){

        $email =  $request->email;
       
        $user = Usuario::where('Correo', $email)->orWhere('Telefono', $email)->update([
        
                'Contrasena'=>$request->password
            ]);

      
            if($user){
                return response()->json([
                    'message'=>'La contraseña se actualizo con éxito.',
                    'user'=>Usuario::where('Correo', $email)->orWhere('Telefono', $email)->get()->first()
                ]);
            
            }else{
                return response()->json([
                    'message'=>'Lo sentimos algo salio mal.',
                    'user'=>$user
                ]);
            
            }

    }
    public function tokenVerification(Request $request)
    {

       
      

        $email =  $request->email;
        $token =  $request->token;

        $user = Usuario::where('Correo', $email)->orWhere('Telefono', $email)->get()->first();
        $passwordReset = PasswordReset::where('email', $user->Correo)->latest()->first();

        return response()->json([
            'passwordReset'=>$passwordReset
        ]);

    }
}
