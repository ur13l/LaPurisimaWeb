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
        return response()->json([
            "id" => $pedido->id,
            "success"=> "true",
            "error" => []
        ]);
    }

    public function cancelar(Request $request){
        $user = Auth::guard('api')->user();
        $pedido = Pedido::where([
            ['id', '=', $request->input('id')],
            ['cliente_id', '=', $user->id]
        ])->first();
        $errors = [];
        $save = false;
        if(isset($pedido)){
            if($pedido->status != Pedido::CANCELADO){
                $pedido->status = Pedido::CANCELADO;
                $save = $pedido->save();
            }
            else{
                $errors[] = "already.cancelled";
            }
            //Aquí se puede enviar una notificación push al conductor para indicar la cancelación de un envío.
        }
        else{
            $errors[] = "unauthorized.user";
        }
        return response()->json([
            "success"=> $save,
            "error" => $errors
        ]);
    }
}
