<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Producto;
use Auth;

class ProductoController extends Controller
{

  /**
   * Función utilizada para crear un nuevo producto.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request){
    $tipoUsuario = Auth::guard('api')->user()['tipo_usuario_id'];
    $errors = [];
    //Solo los usuarios de tipo 1 (Administrador) son autorizados para crear nuevos productos.
    if($tipoUsuario == 1){
      Producto::create($request->all());
      $success = "true";
    }
    else {
      $success = "false";
      $errors[] = "not.authorized";
    }
    return response()->json([
      "success" => $success,
      "error" => $errors
    ]);
  }

  /**
   * Función utilizada para crear un nuevo producto.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request){
    $tipoUsuario = Auth::guard('api')->user()['tipo_usuario_id'];
    $errors = [];
    //Solo los usuarios de tipo 1 (Administrador) son autorizados para crear nuevos productos.
    if($tipoUsuario == 1){
      $id = $request->input('id');
      $producto = Producto::find($id);
      $producto->update($request->all());
      $success = $producto->save();
    }
    else {
      $success = "false";
      $errors[] = "not.authorized";
    }
    return response()->json([
      "success" => $success,
      "error" => $errors
    ]);
  }

}
