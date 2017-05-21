<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Token;
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
     Token::create([
       'token' => $token
     ]);
     return response()->json([
         "success" => true,
         "errors" => [],
         "status" => 200,
         "data" => true
     ]);
 }

}
