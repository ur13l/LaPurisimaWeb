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



    public function disponibilidad(Request $request){
        $productos = \GuzzleHttp\json_decode($request->input('productos'));
        //Se hace una iteración por los detalles para comprobar que hay suficiente stock de todos los productos.
        $insufficientStock = [];
        $success = true;

        foreach($productos  as $detalle){
            $producto = Producto::find($detalle->id);
            if($producto->stock < $detalle->cantidad){
                $success = false;
                $insufficientStock[] = $producto->nombre;
            }
        }

        return response()->json(array(
           "success" => $success,
            "productos" => $insufficientStock
        ));
    }
}
