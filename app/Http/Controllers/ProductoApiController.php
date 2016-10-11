<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Producto;


class ProductoApiController extends Controller
{
    /**
     * Devuelve un arreglo con la lista de productos disponibles.
     * @route /producto/get
     * @param Request $request
     * @return array
     */
    public function getProductos(Request $request){
        $search = $request->input('search');
        return Producto::where('nombre', 'LIKE', "%$search%")->get();
    }
}
