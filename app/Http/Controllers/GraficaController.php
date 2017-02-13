<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Yajra\Datatables\Datatables;
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
             return view('graficas.index');
         }
       return redirect()->action('HomeController@index');
     }




}
