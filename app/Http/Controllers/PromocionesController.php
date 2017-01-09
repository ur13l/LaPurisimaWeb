<?php

namespace App\Http\Controllers;

use App\Descuento;
use Illuminate\Http\Request;

use App\Http\Requests;

class PromocionesController extends Controller
{
    /**
     * Función que devuelve la vista con el index de las promociones.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index(Request $request){
        return view('promociones.index');
    }


    function usuario(Request $request){
        $user_ids = $request->input('select-usuario');
        $producto_ids = $request->input('select-producto');
        foreach($user_ids as $user_id){
            //Si fue por producto
            if(isset($producto_ids)){
                foreach($producto_ids as $producto_id){
                    $promoN = array();
                    $promoN['user_id'] = $user_id;
                    $promoN['producto_id'] = $producto_id;
                    $promoN['descuento'] = $request->input('descuentoPrecioInput1');
                    $promoN['descuento_porcentaje'] = $request->input('descuentoPorcInput1');
                    $promoN['fecha_vencimiento'] = $request->input('fecha');
                    $promoN['usos_restantes'] = $request->input('limiteNum');
                    Descuento::create($promoN);
                }
            }
            else{

            }
            $promoN = array();
            $promoN['user_id'] = $user_id;

        }

    }
}
