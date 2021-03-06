<?php

namespace App\Http\Controllers;

use App\DatosRepartidor;
use App\Producto;
use Illuminate\Http\Request;

use App\Pedido;
use App\Detalle;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class PedidoController extends Controller
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

    /**************************** VISTAS ****************************************/


    /**
     * Muestra la interfaz principal de pedidos. En donde se listan los pedidos recibidos, los asignados y completados.
     * @route /pedidos/
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function pedidos()  {
        $pedidosPendientes = Pedido::where('status', '=', Pedido::SOLICITADO)->get();
        $pedidosAsignados = Pedido::where('status', '=', Pedido::ASIGNADO)->paginate(10);
        $pedidosTerminados = Pedido::where('status', '=', Pedido::ENTREGADO)
            ->orWhere('status', '=', Pedido::CANCELADO)->paginate(10);
        return view('pedidos.index');
    }

    /**
     * Devuelve la vista con el detalle del pedido renderizado.
     * @route /pedidos/{pedido_id}
     * @param $pedido_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function detalle($pedido_id, Request $request){
        $messages = $request->input('messages');
        $pedido = Pedido::find($pedido_id);
        $repartidores = User::where('tipo_usuario_id', '=', '2')->leftJoin('datos_repartidores', 'datos_repartidores.user_id', '=', 'users.id')
            ->where('datos_repartidores.status','=','1')
            ->select('users.*')->paginate(100);
        return view('pedidos.detalle', [ "pedido" =>$pedido, "repartidores" => $repartidores, "messages" => $messages]);
    }

    /**
     * Devuelve una vista con una lista de repartidores obtenida desde una búsqueda.
     * @route /pedidos/repartidores
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function repartidores(Request $request){
        $search = $request->input('search');
        $repartidores = User::where('tipo_usuario_id', '=', '2')->join('datos_repartidores', 'users.id', '=', 'datos_repartidores.user_id')->where('status', 1)->where('nombre', 'like', '%'.$search.'%')->paginate(100);
        return view('layouts.repartidores', ['repartidores' => $repartidores]);
    }

    /**
    * @route /pedidos/nuevo
    * @param $request
    * @return
    */
    public function nuevoPedido(Request $request){
        $productos = Producto::all();
       return view('pedidos.nuevo', ['productos' => $productos]);
    }

    public function generarNuevoPedido(Request $request){
        $this->validate($request, [
            'telefono' => 'required',
            'nombre' => 'required',
            'direccion' => 'required',
            'productos' => 'required'
        ]);

        $productos = json_decode($request->input('productos'));

        //Se hace una iteración por los detalles para comprobar que hay suficiente stock de todos los productos.
        $insufficientStock = '';

        foreach($productos  as $detalle){
            $producto = Producto::find($detalle->id);
            if($producto->stock < $detalle->cantidad){
                $insufficientStock .= $producto->nombre . " ";
            }
        }

        if($insufficientStock != ''){
            return redirect()->action("PedidoController@nuevoPedido")->withErrors(["No hay suficiente stock para los siguientes productos: [" . $insufficientStock . "]"]);
        }

        $user = User::where('telefono', '=', $request->input('telefono'))->first();
        if(!isset($user)){
            $user = new User();
            $user->telefono = $request->input('telefono');
            $user->email = $user->telefono . "@lapurisima.dev";
            $user->nombre = $request->input('nombre');
            $user->tipo_usuario_id = "3";
        }

        $user->referencia = $request->input('referencia');
        $user->save();

        //Se crea el pedido y se definen datos como fecha y usuario que lo solicitó.
        $pedido = Pedido::create(array(
            "cliente_id" => $user->id,
            "latitud" => $request->input('latitud'),
            "longitud" => $request->input('longitud'),
            "direccion" => $request->input('direccion'),
            "tipo_pago_id" => $request->input('tipo_pago_id'),
            "cantidad_pago" => $request->input('cantidad_pago'),
            "status" => Pedido::SOLICITADO
        ));

        $pedido->cliente_id = $user->id;
        $pedido->fecha = Carbon::now('America/Mexico_City');
        $pedido->save();
        $total = 0;

        foreach( $productos as $detalle) {
            //TODO: Quitar este jarcoud
            $detalle->producto_id = $detalle->id;
            //---------------------------------------
            $det = array(
                "pedido_id" => $pedido->id,
                "producto_id" => $detalle->id,
                "cantidad" => $detalle->cantidad,
            );
            $d = Detalle::create($det);
            $producto = Producto::find($d->producto->id);
            $producto->stock -= $d->cantidad;
            $producto->save();
            $total += $producto->precio * $d->cantidad;
        }
        $pedido->total = $total;
        $pedido->status = Pedido::SOLICITADO;
        $pedido->save();

        PromocionesController::aplicarPromociones($user->id, $productos, $pedido);

        return redirect()->route('detalle', ['pedido_id' => $pedido->id]);

    }


    /****************************************** JSON Data *************************************************/

    /**
     * Servicio que devuelve la tabla de los pedidos con status SOLICITADO.
     * @route /pedidos/solicitados
     * @return mixed
     */
    public function pedidosSolicitadosTable()
    {
        $pedidos = Pedido::where('status', '=', Pedido::SOLICITADO)->orderBy('fecha', 'desc')->with('cliente')
            ->with('detalles')
            ->with('detallesDescuento')
            ->with('detallesDescuento.desc')
            ->with('detalles.producto')->get();

        return Datatables::of($pedidos)->make(true);
    }

    /**
     * Servicio que devuelve la tabla de los pedidos con status ASIGNADOS y EN CAMINO.
     * @route /pedidos/asignados
     * @return mixed
     */
    public function pedidosAsignadosTable()
    {
        $pedidos = Pedido::where('status', '=', Pedido::ASIGNADO)->orWhere('status', '=', Pedido::EN_CAMINO)
            ->with('cliente')->with('detalles')
            ->with('detallesDescuento')
            ->with('detallesDescuento.desc')
            ->with('detalles.producto')->get();

        return Datatables::of($pedidos)->make(true);
    }


    /**
     * Función para devolver el historial de pedidos hechos por un usuario en forma de tabla.
     * @route /pedidos/historial-pedidos
     * @param Request $request
     * @return mixed
     */
    public function historialPedidosTable(Request $request){
        $pedidos = Pedido::where('cliente_id', '=', $request->input('id'))
        ->with('cliente')
        ->with('detalles')
        ->with('detallesDescuento')
        ->with('detallesDescuento.desc')
        ->with('detalles.producto')->get();
        return Datatables::of($pedidos)->make(true);
    }

    /**
     * Función para devolver el historial de envíos de un repartidor en forma de tabla.
     * @route /pedidos/historial-envios
     * @param Request $request
     * @return mixed
     */
    public function historialEnviosTable(Request $request){
        $pedidos = Pedido::where('conductor_id', '=', $request->input('id'))->with('cliente')->with('detalles')
            ->with('detalles.producto')->get();
        return Datatables::of($pedidos)->make(true);
    }

    /**
     * Lista de repartidores cercanos (15km) de un punto determinado
     * @route /pedidos/repartidores-json
     * @param Request $request (Contiene latitud y longitud)
     * @return \Illuminate\Http\JsonResponse
     */
    public function repartidoresJSON(Request $request){
        $latitude = $request->input('latitud');
        $longitude = $request->input('longitud');
        $repartidores = DatosRepartidor::where('status', '=', DatosRepartidor::ACTIVO)->where(DB::raw("(POW(69.1 * (latitud - $latitude), 2) + POW(69.1 * ($longitude - longitud) * COS(latitud / 57.3),2))"), '<', DB::raw("SQRT(25)"))->with('user')->get();
        return response()->json($repartidores->all());
    }

    /**
     * Función para asignar un pedido a un repartidor en particular.
     * MEJORA: DEBERÍA VERIFICAR QUE EL CONDUCTOR CUENTE CON EL STOCK NECESARIO.
     * @route /pedidos/asignar
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function asignarRepartidor(Request $request){
        $idRepartidor = $request->input('repartidor-definido-id');
        $repartidor = User::find($idRepartidor);
        $idPedido = $request->input('pedido-id');
        $messages = null;
        if(Auth::user()->tipo_usuario_id == 1) {
            if (isset($repartidor)) {
                if ($repartidor->tipo_usuario_id == 2) {
                    $pedido = Pedido::find($idPedido);
                    if(self::tieneSuficienteStock($pedido, $repartidor)){
                        self::modificarStockRepartidor($pedido, $repartidor, 'resta');
                        $pedido->conductor_id = $idRepartidor;
                        $pedido->status = Pedido::ASIGNADO;
                        $pedido->save();
                    }
                    else{
                        $messages = 'no.stock';
                    }
                }
            }
        }
        //ASIGNADO EL PEDIDO SE LE PUEDE ENVIAR UNA NOTIFICACION AL REPARTIDOR.
        return redirect()->route('detalle', ['pedido_id' => $idPedido, 'messages' => $messages]);

    }

    /**
     * Función para cancelar un pedido que no ha sido entregado.
     * @route /pedidos/cancelar
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelarPedido(Request $request){
        $idPedido = $request->input('id_pedido');
        $view = $request->input('view');
        $pedido = Pedido::find($idPedido);
        $errors = [];
        $save = false;
        if (isset($pedido)) {
            if ($pedido->status != Pedido::CANCELADO && $pedido->status != Pedido::FAILED && $pedido->status != Pedido::ENTREGADO) {
                $pedido->status = Pedido::CANCELADO;
                if(isset($pedido->repartidor))
                    self::modificarStockRepartidor($pedido, $pedido->repartidor, "suma");
                foreach ($pedido->detalles as $detalle) {
                    $producto = Producto::find($detalle->producto->id);
                    $producto->stock += $detalle->cantidad;
                    $producto->save();
                }
                $save = $pedido->save();
            } elseif ($pedido->status != Pedido::ENTREGADO) {
                $errors[] = "already.delivered";
            } else {
                $errors[] = "already.cancelled";
            }
            //Aquí se puede enviar una notificación push al conductor para indicar la cancelación de un envío.
        }

        //ASIGNADO EL PEDIDO SE LE PUEDE ENVIAR UNA NOTIFICACION AL REPARTIDOR.
        return redirect()->route($view, ['pedido_id' => $idPedido]);

    }

    /**
     * Función para obtener al repartidor asignado al pedido.
     * @route: /pedidos/repartidor-pedido-json
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerRepartidor(Request $request){
        $pedido = Pedido::find($request->input('id_pedido'));
        $repartidor = $pedido->repartidor;
        $datosRepartidor = DatosRepartidor::where('user_id', '=', $repartidor->id)->with('user')->first()->toArray();
        return [$datosRepartidor];
    }




    /******************************************* Funciones Estáticas **************************************/

    /**
     * Función para comprobar si un repartidor cuenta con el stock suficiente para cubrir un pedido.
     * @param $pedido
     * @param $repartidor
     * @return bool
     */
    public static function tieneSuficienteStock($pedido, $repartidor){
        $detalles = $pedido->detalles;
        $stockRepartidor = $repartidor->datosRepartidor->productos;
        foreach($detalles as $detalle){
            $exists = false;
            foreach($stockRepartidor as $stock){
                if($stock->id == $detalle->producto_id){
                    $exists = true;
                    if($stock->pivot->cantidad < $detalle->cantidad){
                        return false;
                    }
                }
            }
            if(!$exists)
                return false;
        }
        return true;
    }


    /**
     * Función para que se resten los productos del stock del repartidor cuando es asignado a un pedido.
     * @param $pedido
     * @param $repartidor
     * @return bool
     */
    public static function modificarStockRepartidor($pedido, $repartidor, $operation){

        $detalles = $pedido->detalles;
        $stockRepartidor = $repartidor->datosRepartidor->productos;
        foreach($detalles as $detalle){
            foreach($stockRepartidor as $stock){
                if($stock->id == $detalle->producto_id){
                    if($operation == "suma"){
                        $stock->pivot->cantidad += $detalle->cantidad;
                    }
                    else{
                        $stock->pivot->cantidad -= $detalle->cantidad;
                    }
                    $stock->pivot->save();
                }
            }
        }
        return true;
    }


}
