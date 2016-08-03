<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Usuario;

class UsuarioController extends Controller
{
  public function update(Request $request){
    Usuario::create($request->all());
    return response()->json([
      "success" => "true"
    ]);
  }
}
