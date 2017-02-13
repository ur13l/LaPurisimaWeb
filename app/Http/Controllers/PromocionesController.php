<?php

namespace App\Http\Controllers;

use App\Descuento;
use App\DetalleDescuento;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

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


    /**
     * Método para crear una lista de promociones activas por usuario.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function usuario(Request $request){
        $user_ids = $request->input('select-usuario');
        $producto_ids = $request->input('select-producto');
        foreach($user_ids as $user_id){
            //Si fue por producto
            if(isset($producto_ids)){
                foreach($producto_ids as $producto_id){
                    $promoN = array();
                    $promoN['user_id'] = $user_id;
                    $promoN['producto_id'] = $producto_id;
                    $promoN['descuento'] = $request->input('descuentoPrecioInput1');
                    $promoN['descuento_porcentaje'] = $request->input('descuentoPorcInput1');
                    $fec = str_replace('/', '-', $request->input('fecha'));
                    $promoN['fecha_vencimiento'] = date('Y-m-d', strtotime($fec));
                    $promoN['usos_restantes'] = $request->input('limiteNum');
                    Descuento::create($promoN);
                }
            }
            else{
                $promoN = array();
                $promoN['user_id'] = $user_id;
                $promoN['descuento'] = $request->input('descuentoPrecioInput');
                $promoN['descuento_porcentaje'] = $request->input('descuentoPorcInput');
                $fec = str_replace('/', '-', $request->input('fecha'));
                $promoN['fecha_vencimiento'] = date('Y-m-d', strtotime($fec));
                $promoN['usos_restantes'] = $request->input('limiteNum');
                Descuento::create($promoN);
            }


        }
        return view('promociones.index', array('message' => 'create'));
    }


    /**
     * Se genera lista de promociones por producto
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function producto(Request $request){
        $producto_ids = $request->input('select-producto');
        foreach($producto_ids as $producto_id){
            $promoN = array();
            $promoN['producto_id'] = $producto_id;
            $promoN['descuento'] = $request->input('descuentoPrecioInput');
            $promoN['descuento_porcentaje'] = $request->input('descuentoPorcInput');
            $fec = str_replace('/', '-', $request->input('fecha'));
            $promoN['fecha_vencimiento'] = date('Y-m-d', strtotime($fec));
            $promoN['usos_restantes'] = $request->input('limiteNum');
            Descuento::create($promoN);
        }
        return view('promociones.index', array('message' => 'create'));
    }

    /**
     * Se guarda una promoción a nivel general para todos los usuarios.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function general(Request $request){
        $promoN = array();
        $promoN['descuento'] = $request->input('descuentoPrecioInput');
        $promoN['descuento_porcentaje'] = $request->input('descuentoPorcInput');
        $fec = str_replace('/', '-', $request->input('fecha'));
        $promoN['fecha_vencimiento'] = date('Y-m-d', strtotime($fec));
        $promoN['usos_restantes'] = $request->input('limiteNum');
        Descuento::create($promoN);
        return view('promociones.index', array('message' => 'create'));
    }


    /**
     * Método de eliminar, recibe una petición con el ID del elemento a eliminar y realiza un soft delete.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminar($id){
        if(Auth::user()->tipo_usuario_id == 1){
            $promocion = Descuento::find($id);
            $promocion->delete();
        }
        return redirect()->action('PromocionesController@index', ['message' => 'delete']);
    }

    /**
     * Servicio que devuelve la tabla de las promociones para DataTables.
     * @route /productos/table
     * @return mixed
     */
    public function table()
    {
        $promociones = Descuento::orderBy('created_at')->with('user')->with('producto')->get();

        return Datatables::of($promociones)->make(true);
    }


    /**
     * Método que devuelve la lista de promociones que pueden aplicarse al usuario en ese momento y con una cantidad de productos definida.
     * @param $id_user
     * @param $productos
     * @return mixed
     */
    public static function aplicarPromociones($id_user, $productos, $pedido){
        $user = User::find($id_user);


        //Primero se verifican los descuentos generales por usuario/venta
        $descuentos = Descuento::where('user_id', $user->id)
            ->where('producto_id', null)
            ->where(function($q) {
                $q->where('fecha_vencimiento', '>=', Carbon::now())
                    ->orWhere('fecha_vencimiento', null);
            })
            ->where(function($q){
                $q->where('usos_restantes', '>', 0)
                    ->orWhere('usos_restantes', null);
            })
            ->get();

        if(count($descuentos) == 0){
        //Se verifican los descuentos generales
            $descuentos =  Descuento::where('user_id', null)
                ->where('producto_id', null)
                ->where(function($q) {
                    $q->where('fecha_vencimiento', '>=', Carbon::now())
                        ->orWhere('fecha_vencimiento', null);
                })
                ->where(function($q){
                    $q->where('usos_restantes', '>', 0)
                        ->orWhere('usos_restantes', null);
                })
                ->get();

            if(count($descuentos) == 0) {

                //Se verifican descuento de usuario por producto
                foreach ($productos as $producto) {
                    $promo = Descuento::where('user_id', $id_user)
                        ->where('producto_id', $producto['producto_id'])
                        ->where(function ($q) {
                            $q->where('fecha_vencimiento', '>=', Carbon::now())
                                ->orWhere('fecha_vencimiento', null);
                        })
                        ->where(function ($q) {
                            $q->where('usos_restantes', '>', 0)
                                ->orWhere('usos_restantes', null);
                        })
                        ->first();
                    if (isset($promo)) {
                        $descuentos[] = $promo;
                    }
                }

                if(count($descuentos) == 0) {
                    foreach ($productos as $producto) {
                        $promo = Descuento::where('user_id', null)
                            ->where('producto_id', $producto['producto_id'])
                            ->where(function ($q) {
                                $q->where('fecha_vencimiento', '>=', Carbon::now())
                                    ->orWhere('fecha_vencimiento', null);
                            })
                            ->where(function ($q) {
                                $q->where('usos_restantes', '>', 0)
                                    ->orWhere('usos_restantes', null);
                            })
                            ->first();
                        if (isset($promo)) {
                            $descuentos[] = $promo;
                        }
                    }
                }
            }
        }


        //Se genera un detalle de cada descuento
        foreach($descuentos as $descuento){
            $desc = 0;
            if(isset($descuento->producto)) {
                if (isset($descuento->descuento) && $descuento->descuento != 0) {
                    $desc += $descuento->descuento;
                } else {
                    $desc += $descuento->producto->precio * (floatval($descuento->descuento_porcentaje / 100));
                }
            }
            else{
                if (isset($descuento->descuento) && $descuento->descuento != 0) {
                    $desc += $descuento->descuento;
                } else {
                    $desc += $pedido->total * ($descuento->descuento_porcentaje / 100);
                }
            }
            DetalleDescuento::create([
                'pedido_id'=>$pedido->id,
                'descuento_id'=>$descuento->id,
                'descuento' => $desc
            ]);
        }
        return null;
    }
}
