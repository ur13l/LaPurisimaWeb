<?php

namespace App\Http\Controllers;

use App\DatosRepartidor;
use App\Producto;
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
         $repartidorfilter = DatosRepartidor::where('user_id','=', $id)->get();
         $repartidores = DatosRepartidor::all();
         $html = '<style>table {border-collapse: collapse;} table, th, td {border: 1px solid black;}</style><table class="table" bordered="1"><tr>';
         $html.= '<th>Repartidor</th> <th>Correo</th><th>Teléfono</th></th><th>Producto</th> <th>Cantidad</th> </tr>';

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
            $html .='</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=reportes.xls");
            echo $html;
}


    /**
     * Función que genera un excel según la consulta.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generaExcelClientes(Request $request){
        $telefono= $request->input('telefono');
        $id= $request->input('invisibleid');
        $repartidorfilter = DatosRepartidor::where('user_id','=', $id)->get();
        $repartidores = DatosRepartidor::all();
        $html = '<style>table {border-collapse: collapse;} table, th, td {border: 1px solid black;}</style><table class="table" bordered="1"><tr>';
        $html.= '<th>Repartidor</th> <th>Correo</th><th>Teléfono</th></th><th>Producto</th> <th>Cantidad</th> </tr>';

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
        $html .='</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=reportes.xls");
        echo $html;
    }


    /**
     * Función que genera un excel según la consulta.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generaExcelBodega(Request $request){
        $telefono= $request->input('telefono');
        $id= $request->input('invisibleid');
        $repartidorfilter = DatosRepartidor::where('user_id','=', $id)->get();
        $repartidores = DatosRepartidor::all();
        $html = '<style>table {border-collapse: collapse;} table, th, td {border: 1px solid black;}</style><table class="table" bordered="1"><tr>';
        $html.= '<th>Repartidor</th> <th>Correo</th><th>Teléfono</th></th><th>Producto</th> <th>Cantidad</th> </tr>';

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
        $html .='</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=reportes.xls");
        echo $html;
    }


    /**
     * Función que genera un excel según la consulta.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generaExcelEntregado(Request $request){
        $telefono= $request->input('telefono');
        $id= $request->input('invisibleid');
        $repartidorfilter = DatosRepartidor::where('user_id','=', $id)->get();
        $repartidores = DatosRepartidor::all();
        $html = '<style>table {border-collapse: collapse;} table, th, td {border: 1px solid black;}</style><table class="table" bordered="1"><tr>';
        $html.= '<th>Repartidor</th> <th>Correo</th><th>Teléfono</th></th><th>Producto</th> <th>Cantidad</th> </tr>';

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
        $html .='</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=reportes.xls");
        echo $html;
    }




}
