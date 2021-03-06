<?php

namespace App\Http\Controllers;


use App\Token;
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
        $pedido->fecha = Carbon::now('America/Mexico_City');
        $pedido->save();

        //Se hace una iteración por los detalles para comprobar que hay suficiente stock de todos los productos.
        $insufficientStock = [];
        foreach( $request->input('detalles') as $detalle){
            $producto = Producto::find($detalle['producto_id']);

            if(isset($producto) && $producto->stock < $detalle['cantidad']){
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
            $detalles = $request->input('detalles');
            foreach( $detalles as $detalle) {
                $detalle['pedido_id'] = $pedido->id;
                $d = Detalle::create($detalle);
                $producto = Producto::find($d->producto->id);
                $producto->stock -= $d->cantidad;
                $producto->save();
                $total += $producto->precio * $d->cantidad;
            }
            $pedido->total = $total;
            $pedido->status = Pedido::SOLICITADO;
            $pedido->save();

            $tokens = Token::pluck('token');
            //Envío de las notificaciones a iOS y Android
            $message = array(
                'title' => "Nuevo Pedido",
                'body' => "Nueva solicitud de pedido",
                'link_url' => url('/pedidos'),
                'click_action' => "https://lapurisimaweb.herokuapp.com/pedidos",
                'icon' => "https://lapurisimaweb.herokuapp.com/img/logo-lapurisima.png",
                'sound' => 'default',
                'priority' => 'high',
                'category' => 'URL_CATEGORY',
                'tag' => ''
            );
            $message_status = \App\Utils\Notifications::sendNotification($tokens, $message, 'notification');
            //Condición que se cumple si fueron enviados los mensajes.
            if(isset($message_status)){
            }

            PromocionesController::aplicarPromociones($cliente->id,$detalles, $pedido);
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
        ])->orWhere(function($query) use ($request , $user){
            $query->where('id', '=', $request->input('id'))
                ->where('conductor_id', '=', $user->id);
            })
            ->first();
        $errors = [];
        $save = false;
        if(isset($pedido)){
            if($pedido->status != Pedido::CANCELADO && $pedido->status != Pedido::FAILED && $pedido->status != Pedido::ENTREGADO){
                $pedido->status = Pedido::CANCELADO;
                if(isset($pedido->repartidor))
                    PedidoController::modificarStockRepartidor($pedido, $pedido->repartidor, 'suma');
                foreach($pedido->detalles as $detalle){
                    $producto = Producto::find($detalle->producto->id);
                    $producto->stock += $detalle->cantidad;
                    $producto->save();
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
            with('repartidor')->with('detallesDescuento')->with('detallesDescuento.descuento')->get()->toArray();
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
            $pedidos = Pedido::where('conductor_id', '=', $user->id)->with('detalles')->with('detalles.producto')->with('cliente')
                ->with('detallesDescuento')->with('detallesDescuento.descuento')->get();
            return $pedidos->toArray();
        }
        else {
            return response()->json([
                "success" => false,
                "error" => ['unauthorized.user']
            ]);
        }
    }

    /**
     * Función para devolver una lista de todos los pedidos solicitados para que el conductor elija cuál desea entregar.
     * @route /pedido/solicitados
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerPedidos(Request $request){
        $user = Auth::guard('api')->user();
        if($user->tipo_usuario_id == 1 || $user->tipo_usuario_id == 2){
            $pedidos = Pedido::where('status', '=', Pedido::SOLICITADO)->orderBy('fecha')->get();
            return $pedidos->toArray();
        }
        return response()->json([
            "success" => false,
            "error" => ['unauthorized.user']
        ]);
    }


    /**
     * Función para asignar repartidor desde la aplicación (API)
     * @route /pedido/asignar
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function asignarRepartidor(Request $request){
        $repartidor = Auth::guard('api')->user();
        $pedido = Pedido::find($request->input('id_pedido'));
        $errors = [];
        $success = false;
        if($repartidor->tipo_usuario_id == 2){
            if(PedidoController::tieneSuficienteStock($pedido, $repartidor)){
                if($pedido->status = Pedido::SOLICITADO) {
                    PedidoController::modificarStockRepartidor($pedido, $repartidor, 'resta');
                    $pedido->conductor_id = $repartidor->id;
                    $pedido->status = Pedido::ASIGNADO;
                    $success = $pedido->save();
                }
                else{
                    $error[] = "invalid.state";
                }
            }
            else{
                $errors[] = 'no.stock';
            }
        }
        else{
            $errors [] = "unauthorized.user";
        }
        return response()->json([
            "success" => $success,
            "error" => $errors
        ]);
    }


    /**
     * Cambia el status del pedido de EN_CAMINO a ENTREGADO. El conductor es el que lo entrega.
     * @route /pedido/finalizar
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function finalizarPedido(Request $request){
        $repartidor = Auth::guard('api')->user();
        $pedido = Pedido::find($request->input('id_pedido'));
        $errors = [];
        $save = false;
        if(isset($pedido)){
            if($pedido->status == Pedido::ASIGNADO || $pedido->status == Pedido::EN_CAMINO){
                $pedido->status = Pedido::ENTREGADO;
                $save = $pedido->save();
            }
            else{
                $errors[] = "invalid.state";
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


    public function pedidoEnCamino(Request $request){
        $repartidor = Auth::guard('api')->user();
        $pedido = Pedido::find($request->input('id_pedido'));
        $errors = [];
        $save = false;
        if(isset($pedido)){
            if($pedido->status == Pedido::ASIGNADO){
                $pedido->status = Pedido::EN_CAMINO;
                $save = $pedido->save();
            }
            else{
                $errors[] = "invalid.state";
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
