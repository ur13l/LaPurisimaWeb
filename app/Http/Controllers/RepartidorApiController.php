<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class RepartidorApiController extends Controller
{

    /**
     * @route /repartidor/status
     * @param Request $request
     */
    public function cambiarStatusRepartidor(Request $request){
        $repartidor = Auth::guard('api')->user();
        $nuevoStatus = $request->input('status');
        $nuevaLat = $request->input('latitud');
        $nuevaLang = $request->input('longitud');
        $save = false;
        $errors = [];
        if(isset($repartidor->datosRepartidor)) {
            $repartidor->datosRepartidor->status = $nuevoStatus;
            if(isset($nuevaLat))
                $repartidor->datosRepartidor->latitud = $nuevaLat;
            if(isset($nuevaLang))
                $repartidor->datosRepartidor->longitud = $nuevaLang;
            $save = $repartidor->datosRepartidor->save();
        }
        else {
            $errors = ['invalid.user'];
        }
        return response()->json([
            "success" => $save,
            "errors" => $errors
        ]);
    }


}
