<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Pedido;
use App\Detalle;
use App\Producto;
use App\Http\Requests;
use Auth;

class PedidoApiController extends Controller

{

    /**
     * Función que controla un nuevo pedido.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function nuevo(Request $request){
        //Se crea el pedido y se definen datos como fecha y usuario que lo solicitó.
        $pedido = Pedido::create($request->except('detalles'));
        $cliente = Auth::guard('api')->user();
        $pedido->cliente_id = $cliente->id;
        $pedido->fecha = Carbon::now();
        $pedido->save();

        //Se hace una iteración por los detalles para comprobar que hay suficiente stock de todos los productos.
        $insufficientStock = [];
        foreach( $request->input('detalles') as $detalle){
            $producto = Producto::find($detalle['producto_id']);
            if($producto->stock < $detalle['cantidad']){
                $insufficientStock[] = $producto->nombre;
            }
        }

        //Si el stock es insuficiente, se enviará un mensaje de error indicando los productos que no se completan.
        if(count($insufficientStock) > 0){
            $pedido->status = Pedido::FAILED;
            $pedido->save();
            return response()->json([
                "id" => $pedido->id,
                "success"=> false,
                "error" => [
                    "insifficient.stock" => $insufficientStock
                ]
            ]);
        }
        //En caso contrario, se registran todos los detalles del pedido de manera normal, restando al stock.
        else {
            $total = 0;
            foreach( $request->input('detalles') as $detalle) {
                $detalle['pedido_id'] = $pedido->id;
                $d = Detalle::create($detalle);
                $producto = Producto::find($d->producto->id);
                $producto->stock -= $d->cantidad;
                $producto->save();
                $total += $producto->precio;
            }
            $pedido->total = $total;
            $pedido->status = Pedido::SOLICITADO;
            $pedido->save();
            return response()->json([
                "id" => $pedido->id,
                "success"=> true,
                "error" => []
            ]);
        }


    }

    /**
     * Función para cancelar un pedido que no ha sido entregado.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelar(Request $request){
        $user = Auth::guard('api')->user();
        $pedido = Pedido::where([
            ['id', '=', $request->input('id')],
            ['cliente_id', '=', $user->id]
        ])->first();
        $errors = [];
        $save = false;
        if(isset($pedido)){
            if($pedido->status != Pedido::CANCELADO && $pedido->status != Pedido::FAILED && $pedido->status != Pedido::ENTREGADO){
                $pedido->status = Pedido::CANCELADO;
                $pedido->total = 0;
                foreach($pedido->detalles as $detalle){
                    $producto = Producto::find($detalle->producto->id);
                    $producto->stock += $detalle->cantidad;
                    $producto->save();
                    $detalle->delete();
                }
                $save = $pedido->save();
            }
            elseif($pedido->status != Pedido::ENTREGADO){
                $errors[] = "already.delivered";
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

    /**
     * Devuelve una lista de pedidos solicitada por el Usuario, muestra todo su historial.
     * Incluye detalles del pedido e información sobre el repartidor.
     * @param Request $request
     * @return mixed
     */
    public function pedidosUsuario(Request $request){
        $user = Auth::guard('api')->user();
        $pedidos = Pedido::where('cliente_id', '=', $user->id)->with('detalles')->with('detalles.producto')->
            with('repartidor')->get()->toArray();
        return $pedidos;
    }

    /**
     * Devuelve una lista de pedidos solicitada por un repartidor, muestra el historial.
     * Incluye detalles del pedido e información sobre el cliente. Requiere autorización del cliente (tipo 2).
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
