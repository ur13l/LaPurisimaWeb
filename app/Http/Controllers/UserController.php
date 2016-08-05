<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\User;

class UserController extends Controller
{
  /**
   * Método para crear a un usuario. Recibe una petición con todos
   * los datos a registrar del usuario.
   * @param  Request $request [JSON que contiene los valores de users]
   * @return [string] [JSON con success, puede ser true o false]
   */
  public function create(Request $request){
    $user = User::create($request->all());
    return response()->json([
      "success" => $user->exists()
    ]);
  }

  /**
   * Función para actualizar a un usuario ya existente, se le envía como parámetro
   * un JSON con todos los campos actualizados.
   * @param  Request $request [JSON que contiene los valores de users]
   * @return [string] [JSON con success, puede ser true o false]
   */
  public function update(Request $request){
    $id = $request->input('id');
    $usuario = User::find($id);
    $saved = false;
    if($usuario->exists()){
      $usuario->update($request->all());
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
    if (Auth::once(['email' => $email, 'password' => $password ])) {
      return Auth::user();
    }
    return response()->json([
      "success"=>"false"
    ]);
  }

  /**
   * [uploadPhoto description]
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function uploadPhoto(Request $request){
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
