<?php

namespace App\Http\Controllers;

use App\DatosRepartidor;
use App\Producto;
use App\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Yajra\Datatables\Datatables;
use Auth;



class ReportesController extends Controller
{
    /**
     * Nueva instancia del controlador, permite que no se utilice esta sesión a menos que se esté logueado.
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
        // $this->middleware('auth.admin');
    }


    /**
     * Función que devuelve la vista principal para generar reportes.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
     public function index(Request $request){
         if(Auth::user()->tipo_usuario_id == 1) {
             return view('reportes.index');
         }
       return redirect()->action('HomeController@index');
     }


     /**
      * Función que genera un excel según la consulta.
      * @param Request $request
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
     public function generaExcel(Request $request){
         $telefono= $request->input('telefono');
         $id= $request->input('invisibleid');
         $tipo= $request->input('tipo');
         $fecha= $request->input('fecha');
         $repartidorfilter = DatosRepartidor::where('user_id','=', $id)->get();
         $repartidores = DatosRepartidor::all();
         $html = '<style>table {border-collapse: collapse;} table, th, td {border: 1px solid black;}</style><table class="table" bordered="1"><tr>';
         switch($tipo){
           case '1':
         $html.= '<th>Repartidor</th> <th>Correo</th><th>Teléfono</th><th>Producto</th> <th>Cantidad</th> </tr>';
         if(count($repartidorfilter) == 0) {
             foreach ($repartidores as $repartidor) {
                 $html .= "<tr>";
                 $html .= "<td>" . $repartidor->user->nombre . "</td>";
                 $html .= "<td>" . $repartidor->user->email . "</td>";
                 $html .= "<td>" . $repartidor->user->telefono . "</td>";
                 $html .= "<td></td>";
                 $html .= "<td></td>";
                 $html .= "</tr>";
                 foreach ($repartidor->productos as $producto) {
                     $html .= "<tr>";
                     $html .= "<td></td>";
                     $html .= "<td></td>";
                     $html .= "<td></td>";
                     $html .= "<td>" . $producto->nombre . "</td>";
                     $html .= "<td>" . $producto->pivot->cantidad . "</td>";
                     $html .= "</tr>";
                 }

             }
         }else{
             foreach ($repartidorfilter as $repartidor) {
                 $html .= "<tr>";
                 $html .= "<td>" . $repartidor->user->nombre . "</td>";
                 $html .= "<td>" . $repartidor->user->email . "</td>";
                 $html .= "<td>" . $repartidor->user->telefono . "</td>";
                 $html .= "</tr>";
                 foreach ($repartidor->productos as $producto) {
                     $html .= "<tr>";
                     $html .= "<td></td>";
                     $html .= "<td></td>";
                     $html .= "<td></td>";
                     $html .= "<td>" . $producto->nombre . "</td>";
                     $html .= "<td>" . $producto->pivot->cantidad . "</td>";
                     $html .= "</tr>";
                 }

             }
         }
         break;
         case '2':
         //Reporte Entregado a clientes por repartidor
         $repartidorfilter = DatosRepartidor::where('user_id','=', $id)->get();
         $html.= "Repartidor ".$repartidorfilter[0]->user->nombre. " Teléfono ".$repartidorfilter[0]->user->telefono;
         $html.= '<th>Cliente</th> <th>Dirección</th><th>Fecha</th><th>Cantidad</th> </tr>';
         if($fecha == ""){
         $pedidos = Pedido::where('conductor_id','=',$repartidorfilter[0]->user_id)->where('status','=','4')->get();
         foreach ($pedidos as $pedido) {
           $html .= "<tr>";
           $html .= "<td>" . $pedido->cliente->nombre . "</td>";
           $html .= "<td>" . $pedido->direccion. "</td>";
           $html .= "<td>" . $pedido->fecha . "</td>";
           $html .= "<td>". $pedido->total ."</td>";
           $html .= "</tr>";
         }
       }else{ //2017-05-01
         //dd($fecha.' 00:00:00');
         $pedidosfilter = Pedido::where('created_at','>=', $fecha.' 00:00:00')->where('conductor_id','=',$repartidorfilter[0]->user_id)->where('status','=','4')->get();
         if($pedidosfilter == "[]"){
         }else{
         foreach ($pedidosfilter as $pedido) {
           $html .= "<tr>";
           $html .= "<td>" . $pedido->cliente->nombre . "</td>";
           $html .= "<td>" . $pedido->direccion. "</td>";
           $html .= "<td>" . $pedido->fecha . "</td>";
           $html .= "<td>". $pedido->total ."</td>";
           $html .= "</tr>";
         }
       }
       }
         break;
         case '3':
        //Reporte  Regresado a bodega por repartidor
        $repartidorfilter = DatosRepartidor::where('user_id','=', $id)->get();
        $html.= "Repartidor ".$repartidorfilter[0]->user->nombre. " Teléfono ".$repartidorfilter[0]->user->telefono;
        $html.= '<th>Cliente</th> <th>Dirección</th><th>Fecha</th></th><th>Cantidad</th> </tr>';

         break;
         case '4':
        //Reporte  Producto entregado a clientes
        $repartidorfilter = DatosRepartidor::where('user_id','=', $id)->get();
        $html.= "Repartidor ".$repartidorfilter[0]->user->nombre. " Teléfono ".$repartidorfilter[0]->user->telefono;
        $html.= '<th>Cliente</th> <th>Dirección</th><th>Fecha</th><th>Producto</th><th>No. Productos</th><th>Cantidad</th> </tr>';
        if($fecha == ""){
        $pedidos = Pedido::where('conductor_id','=',$repartidorfilter[0]->user_id)->where('status','=','4')->get();
        foreach ($pedidos as $pedido) {
          $html .= "<tr>";
          $html .= "<td>" . $pedido->cliente->nombre . "</td>";
          $html .= "<td>" . $pedido->direccion. "</td>";
          $html .= "<td>" . $pedido->fecha . "</td>";
          $html .= "<td> </td>";
          $html .= "<td> </td>";
          $html .= "<td>". $pedido->total ."</td>";
          $html .= "</tr>";
            foreach ($pedido->detalles as $detalle) {
              $html .= "<tr>";
              $html .= "<td> </td>";
              $html .= "<td> </td>";
              $html .= "<td> </td>";
              $html .= "<td>" . $detalle->producto->nombre . "</td>";
              $html .= "<td>" .   $detalle->cantidad . "</td>";
              $html .= "<td> </td>";
            }
        }
        }else{ //2017-05-01
        //dd($fecha.' 00:00:00');
        $pedidosfilter = Pedido::where('created_at','>=', $fecha.' 00:00:00')->where('conductor_id','=',$repartidorfilter[0]->user_id)->get();
        if($pedidosfilter == "[]"){
        }else{
        foreach ($pedidosfilter as $pedido) {
          $html .= "<tr>";
          $html .= "<td>" . $pedido->cliente->nombre . "</td>";
          $html .= "<td>" . $pedido->direccion. "</td>";
          $html .= "<td>" . $pedido->fecha . "</td>";
          $html .= "<td>". $pedido->total ."</td>";
          $html .= "</tr>";
        }
        }
        }
         break;
       }
            $html .='</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=reportes.xls");
            echo $html;
}





}
