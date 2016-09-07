<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pedido;
use App\Detalle;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{


    /**
     * Create a new controller instance.
     *
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
}
