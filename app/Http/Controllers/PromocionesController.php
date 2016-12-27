<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PromocionesController extends Controller
{
    /**
     * Función que devuelve la vista con el index de las promociones.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index(Request $request){
        return view('promociones.index');
    }
}
