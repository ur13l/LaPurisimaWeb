<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\User;

class UserController extends Controller
{
  /**
   * Método para crear a un usuario. Recibe una petición con todos los datos.
   * @param  Request $request []
   * @return [type]           [description]
   */
  public function create(Request $request){
    User::create($request->all());
    return response()->json([
      "success" => "true"
    ]);
  }

  /**
   * [update description]
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function update(Request $request){
    $id = $request->input('id');
    $usuario = User::find(8);
    $usuario->update($request->all());
    $usuario->save();
    return response()->json([
      "success" => "true"
    ]);
  }

  public function authenticate(Request $request){
    $email = $request->input('email');
    $password = $request->input('password');
    echo $email;
    echo $password;
    if (Auth::attempt(['email' => $email, 'password' => $password ])) {
            // Authentication passed...
            return "success";
    }
    return "fail";
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
