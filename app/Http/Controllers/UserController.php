<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\User;
use App\Http\Controllers\ImageController;
use Carbon\Carbon;
use Mail;
use Validator;

class UserController extends Controller
{
  /**
   * Método para crear a un usuario. Recibe una petición con todos
   * los datos a registrar del usuario.
   * @param  Request $request [JSON que contiene los valores de users]
   * @return [string] [JSON con success, puede ser true o false]
   */
  public function create(Request $request){
    $rules = array('email' => 'unique:users,email');
    $validator = Validator::make($request->all(), $rules);
    $errors = [];
      $success = true;
    if ($validator->fails()) {
      $success = false;
      $errors[] = "email.exists";
    }
    else{
        $user = User::create($request->except('imagen_usuario'));
        $user->tipo_usuario_id = 3;
        $user->save();
        $data = $request->input('imagen_usuario');
        if(isset($data)) {
            $route = "storage/perfil/";
            $user->imagen_usuario = ImageController::saveImage($data, $route, $user->id);
            $success = $user->save();
        }
    }
    return response()->json([
      "success" => var_export($success, true),
      "error" => $errors
    ]);
  }

  /**
   * Función para actualizar a un usuario ya existente, se le envía como parámetro
   * un JSON con todos los campos actualizados.
   * @param  Request $request [JSON que contiene los valores de users]
   * @return [string] [JSON con success, puede ser true o false]
   */
  public function update(Request $request){
    $usuario = Auth::guard('api')->user();
    $saved = false;
    if($usuario->exists()){
      if(base64_decode($request->input('imagen_usuario'))){
        $usuario->update($request->except('imagen_usuario'));
        $data = $request->input('imagen_usuario');
        $route = "storage/perfil/";
        $usuario->imagen_usuario = ImageController::saveImage($data, $route, $usuario->id);
      }
      else{
        $usuario->update($request->all());
      }

      $saved = $usuario->save();
    }
    return response()->json([
      "success" => $saved
    ]);
  }

  /**
   * Método de autenticación de usuario, recibe el email y password
   * que compara contra la base de datos y devuelve la instancia correcta
   * de User o un error.
   * @param  Request $request [JSON con email y password]
   * @return [User]           [Devuelve el usuario logueado]
   */
  public function authenticate(Request $request){
    $email = $request->input('email');
    $password = $request->input('password');
    $errors = ["bad.login"];
    if (Auth::once(['email' => $email, 'password' => $password ])) {
      return Auth::user();
    }

    return response()->json([
      "success"=>"false",
      "error" => $errors
    ]);
  }

  /**
   * [uploadPhoto description]
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function uploadImage(Request $request){
    $file = $request->file('imagen_usuario');
    $id = $request->input('id');
    if ($file->isValid()) {
      $destinationPath = "img";
      $file->move($destinationPath, $id . $file->getClientOriginalExtension());
      return response()->json([
        "success" => "true"
      ]);
    }
    return response()->json([
      "success" => "false"
    ]);
  }


}
