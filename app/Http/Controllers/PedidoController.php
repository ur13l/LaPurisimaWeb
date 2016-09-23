<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pedido;
use App\Detalle;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;
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
     * Show the application dashboard.
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

    public function getRowDetailsData()
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


}
