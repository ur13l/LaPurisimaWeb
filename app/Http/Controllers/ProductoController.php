<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Producto;

class ProductoController extends Controller
{
    public function update(Request $request){
      Producto::create($request->all());
      return response()->json([
        "success" => $request->all()
      ]);
    }

}
