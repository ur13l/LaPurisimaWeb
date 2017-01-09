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


    /**
     * Método que verifica la disponibilidad de un producto.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Método para devolver el contenido de una búsqueda de usuarios
     * @param Request $request
     */
    public function search(Request $request){
        $q = $request->q;
        $page = $request->page;
        $productos = Producto::where("nombre", 'like', "%$q%")
            ->paginate($page);
        return $productos;
    }
}
