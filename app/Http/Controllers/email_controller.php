<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class email_controller extends Controller {
   public function basic_email() {
      $data = array('message'=>"Este es un correo basico de pruebas");
   
      $email = Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('workemailnelson@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
            // FROM , SUBJECT
         $message->from('workemailnelson@gmail.com','BASIC EMAIL');
      });
      if($email){
         return response()->json([
            'message'=>'Correo Enviado',
            'data'=>$data
        ]);
      }else{

         return response()->json([
            'message'=>'Lo sentimos, algo salio mal!.',
            'data'=>$data
        ]);
      }
 

   }
   public function html_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "HTML Email Sent. Check your inbox.";
   }
   public function attachment_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }
}