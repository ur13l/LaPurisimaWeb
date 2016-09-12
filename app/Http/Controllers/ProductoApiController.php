<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Producto;


class ProductoApiController extends Controller
{
    public function getProductos(Request $request){
        return Producto::all()->toArray();
    }
}
