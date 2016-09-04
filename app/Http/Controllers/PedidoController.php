<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Pedido;
use App\Detalle;
use App\Http\Requests;
use Auth;

class PedidoController extends Controller
{
    public function nuevo(Request $request){
        $pedido = Pedido::create($request->except('detalles'));
        $cliente = Auth::guard('api')->user();
        $pedido->cliente_id = $cliente->id;
        $pedido->save();
        foreach( $request->input('detalles') as $detalle){
            $detalle['pedido_id'] = $pedido->id;
            Detalle::create($detalle);
        }
    }
}
