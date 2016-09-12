<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Pedido;
use App\Detalle;
use App\Http\Requests;
use Auth;

class PedidoApiController extends Controller

{

    public function nuevo(Request $request){
        $pedido = Pedido::create($request->except('detalles'));
        $cliente = Auth::guard('api')->user();
        $pedido->cliente_id = $cliente->id;
        $pedido->fecha = Carbon::now();
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

    public function pedidosUsuario(Request $request){
        $user = Auth::guard('api')->user();
        $pedidos = Pedido::where('cliente_id', '=', $user->id)->with('detalles')->with('detalles.producto')->
            with('repartidor')->get()->toArray();
        return $pedidos;
    }

    public function pedidosRepartidor(Request $request){
        $user = Auth::guard('api')->user();
        if($user->tipo_usuario_id == 2) {
            $pedidos = Pedido::where('conductor_id', '=', $user->id)->with('detalles')->with('detalles.producto')->with('cliente')->get();
            return $pedidos->toArray();
        }
        else {
            return response()->json([
                "success" => false,
                "error" => ['unauthorized.user']
            ]);
        }
    }
}
