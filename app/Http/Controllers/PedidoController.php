<?php

namespace App\Http\Controllers;

use App\DatosRepartidor;
use App\Producto;
use Illuminate\Http\Request;

use App\Pedido;
use App\Detalle;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class PedidoController extends Controller
{


    /**
     * Nueva instancia del controlador, permite que no se utilice esta sesión a menos que se esté logueado.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la interfaz principal de pedidos. En donde se listan los pedidos recibidos, los asignados y completados.
     *
     * @return \Illuminate\Http\Response
     */
    public function pedidos()  {
        if(Auth::user()->tipo_usuario_id == 1 || Auth::user()->tipo_usuario_id == 2){
            $pedidosPendientes = Pedido::where('status', '=', Pedido::SOLICITADO)->get();
            $pedidosAsignados = Pedido::where('status', '=', Pedido::ASIGNADO)->paginate(10);
            $pedidosTerminados = Pedido::where('status', '=', Pedido::ENTREGADO)
                ->orWhere('status', '=', Pedido::CANCELADO)->paginate(10);
            return view('pedidos.index', [
                'pedidosPendientes' => $pedidosPendientes,
                'pedidosAsignados' => $pedidosAsignados,
                'pedidosTerminados' => $pedidosTerminados,
            ]);
        }

        return redirect()->action('HomeController@index');
    }

    /**
     * @return mixed
     */
    public function pedidosSolicitadosTable()
    {
        $pedidos = Pedido::where('status', '=', Pedido::SOLICITADO)->with('cliente')->with('detalles')
            ->with('detalles.producto')->get();

        return Datatables::of($pedidos)->make(true);
    }


    public function detalle($pedido_id){
        if(Auth::user()->tipo_usuario_id == 1 || Auth::user()->tipo_usuario_id == 2) {
            $pedido = Pedido::find($pedido_id);
            $repartidores = User::where('tipo_usuario_id', '=', '2')->paginate(100);
            return view('pedidos.detalle', [ "pedido" =>$pedido, "repartidores" => $repartidores ]);
        }
        return redirect()->action('HomeController@index');
    }

    public function repartidores(Request $request){
        $search = $request->input('search');
        $repartidores = User::where('tipo_usuario_id', '=', '2')->where('nombre', 'like', '%'.$search.'%')->paginate(100);
        return view('layouts.repartidores', ['repartidores' => $repartidores]);
    }

    public function repartidoresJSON(Request $request){
        $latitude = $request->input('latitud');
        $longitude = $request->input('longitud');
        $repartidores = DatosRepartidor::where(DB::raw("(POW(69.1 * (latitud - $latitude), 2) + POW(69.1 * ($longitude - longitud) * COS(latitud / 57.3),2))"), '<', DB::raw("SQRT(25)"))->with('user')->get();
        return response()->json($repartidores->all());
    }

    public function asignarRepartidor(Request $request){
        $idRepartidor = $request->input('repartidor-definido-id');
        $repartidor = User::find($idRepartidor);
        $idPedido = $request->input('pedido-id');
        if(Auth::user()->tipo_usuario_id == 1) {
            if (isset($repartidor)) {
                if ($repartidor->tipo_usuario_id == 2) {
                    ;
                    $pedido = Pedido::find($idPedido);
                    $pedido->conductor_id = $idRepartidor;
                    $pedido->status = Pedido::ASIGNADO;
                    $pedido->save();
                }
            }
        }
        //ASIGNADO EL PEDIDO SE LE PUEDE ENVIAR UNA NOTIFICACION AL REPARTIDOR.
        return redirect()->route('detalle', ['pedido_id' => $idPedido]);

    }

    /**
     * Función para cancelar un pedido que no ha sido entregado.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelarPedido($idPedido){
        if(Auth::user()->tipo_usuario_id == 1) {
            $pedido = Pedido::find($idPedido);
            $errors = [];
            $save = false;
            if (isset($pedido)) {
                if ($pedido->status != Pedido::CANCELADO && $pedido->status != Pedido::FAILED && $pedido->status != Pedido::ENTREGADO) {
                    $pedido->status = Pedido::CANCELADO;
                    $pedido->total = 0;
                    foreach ($pedido->detalles as $detalle) {
                        $producto = Producto::find($detalle->producto->id);
                        $producto->stock += $detalle->cantidad;
                        $producto->save();
                    }
                    $save = $pedido->save();
                } elseif ($pedido->status != Pedido::ENTREGADO) {
                    $errors[] = "already.delivered";
                } else {
                    $errors[] = "already.cancelled";
                }
                //Aquí se puede enviar una notificación push al conductor para indicar la cancelación de un envío.
            }

            //ASIGNADO EL PEDIDO SE LE PUEDE ENVIAR UNA NOTIFICACION AL REPARTIDOR.
            return redirect()->route('detalle', ['pedido_id' => $idPedido]);
        }
    }


    public static function tieneSuficienteStock($pedido, $repartidor){
        $detalles = $pedido->detalles;
        $stockRepartidor = $repartidor->datosRepartidor->productos;
        foreach($detalles as $detalle){
            $exists = false;
            foreach($stockRepartidor as $stock){
                if($stock->id == $detalle->producto_id){
                    $exists = true;
                    if($stock->pivot->cantidad < $detalle->cantidad){
                        return false;
                    }
                }
            }
            if(!$exists)
                return false;
        }
        return true;
    }

    public static function restarStockRepartidor($pedido, $repartidor){

        $detalles = $pedido->detalles;
        $stockRepartidor = $repartidor->datosRepartidor->productos;
        foreach($detalles as $detalle){
            foreach($stockRepartidor as $stock){
                if($stock->id == $detalle->producto_id){
                    $stock->pivot->cantidad -= $detalle->cantidad;
                    $stock->pivot->save();
                }
            }
        }
        return true;
    }




}
