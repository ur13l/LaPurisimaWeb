<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Yajra\Datatables\Datatables;
use App\Pedido;
use Carbon\Carbon;
use Auth;



class GraficaController extends Controller
{
    /**
     * Nueva instancia del controlador, permite que no se utilice esta sesión a menos que se esté logueado.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.admin');
    }




    /**
     * Función que devuelve la vista principal para generar graficas.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
     public function index(Request $request){
         if(Auth::user()->tipo_usuario_id == 1) {
            $fecha = Carbon::now('America/Mexico_City');
            $anio = Carbon::now('America/Mexico_City')->year;
            $totales = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $pedidosarra = array(array());
           //año actual
            $pedidos = Pedido::where('created_at','>=', $anio.'-01-01 00:00: 00')->where('status','=','4')->get();
             foreach ($pedidos as $pedido){
               if($pedido->fecha >= $anio."-01"){
                 $totales[0]+= $pedido->total;
               }
               if($pedido->fecha >= $anio."-02"){
                 $totales[1]+= $pedido->total;
               }
               if($pedido->fecha >= $anio."-03"){
                 $totales[2]+= $pedido->total;
               }
               if($pedido->fecha >= $anio."-04"){
                 $totales[3]+= $pedido->total;
               }
               if($pedido->fecha >= $anio."-05"){
                 $totales[4]+= $pedido->total;
               }
               if($pedido->fecha >= $anio."-06"){
                 $totales[5]+= $pedido->total;
               }
               if($pedido->fecha >= $anio."-07"){
                 $totales[6]+= $pedido->total;
               }
               if($pedido->fecha >= $anio."-08"){
                 $totales[7]+= $pedido->total;
               }
               if($pedido->fecha >= $anio."-09"){
                 $totales[8]+= $pedido->total;
               }
               if($pedido->fecha >= $anio."-10"){
                 $totales[9]+= $pedido->total;
                }
               if($pedido->fecha >= $anio."-11"){
                 $totales[10]+= $pedido->total;
                 }
               if($pedido->fecha >= $anio."-12"){
                 $totales[11]+= $pedido->total;
                  }
                }
              
             return view('graficas.index', ['totales' => $totales]);
         }
       return redirect()->action('HomeController@index');
     }



}
