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
         $id = $request->input('user_id');

         $repartidores = DatosRepartidor::all();

         $html = '';
         foreach($repartidores as $repartidor){
             $html.="<h1>".$repartidor->user->nombre."</h1>";
             $html.="<h2>".$repartidor->user->correo."</h2>";
             foreach($repartidor->productos as $producto){
                 $html .= "<p>".$producto->nombre."</p>";
                 $html .= "<p>".$producto->pivot->cantidad."</p><hr>";
             }

         }


         return $html;


         /**
          $productos = DB::table('productos')->get();
            $output = "";
            $output .= '<table class="table" bordered="1"><tr>          ';
          $output.= '<th> nombre</th> <th> stock</th> <th> contenido</th>';
            $output .= '</tr>';
          foreach ($productos as $producto) {
                 $output .= '
                      <tr>
                           <td>'.$producto->nombre.'</td>
                           <td>'.$producto->stock.'</td>
                           <td>'.$producto->contenido.'</td>
                      </tr>
                 ';

               }
            $output .= '</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=reportes.xls");
              echo $output;
          * */
}

}
