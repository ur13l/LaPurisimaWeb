<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Token;
use App\Utils;
use App\Http\Requests;

class NotificacionController extends Controller
{
  /**
  * Notificación: RegistrarToken
  * params: [token]
  * Función para guardar un nuevo token de dispositivo.
  * @param Request $request
  * @return \Illuminate\Http\JsonResponse
  */
 public function registrar(Request $request) {
     $token = $request->input('token');

     $tk = Token::where('token', $token)->get()->first();
     if(!isset($tk)){
       Token::create([
         'token' => $token
       ]);
     }
     return response()->json([
         "success" => true,
         "errors" => [],
         "status" => 200,
         "data" => true
     ]);
 }


public function enviarNotificacion( Request $request ) {

  $tokens = Token::pluck('token');
 //Envío de las notificaciones a iOS y Android
 $message = array(
            'title' => "Título de prueba",
            'body' => "Mensaje",
            'link_url' => "",
            'sound' => 'default',
            'priority' => 'high',
            'category' => 'URL_CATEGORY',
            'tag' => ''
          );
        $message_status = \App\Utils\Notifications::sendNotification($tokens, $message, 'notification');
        //Condición que se cumple si fueron enviados los mensajes.
        if(isset($message_status)){
        }


  }



}
