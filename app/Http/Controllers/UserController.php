<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;

class UserController extends Controller
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
     * Función que devuelve la vista principal para la administración de usuarios.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        return view('usuarios.index');
    }

    /**
     * Se abre el detalle del usuario
     * @param $id_user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detalle($id_user){
        $user = User::find($id_user);
        return view('usuarios.detalle', ["user" => $user]);
    }

    public function editar($id_user){
        $user = User::find($id_user);
        return view("usuarios.editar", ["user" => $user]);

    }

    /**
     * Servicio que devuelve la tabla de los usuarios que son repartidores
     * @route /usuarios/repartidores
     * @return mixed
     */
    public function repartidores()
    {
        $repartidores = User::where('tipo_usuario_id', '=', User::REPARTIDOR)
            ->select(['id', 'imagen_usuario', 'nombre', 'email', 'telefono', 'datos_repartidor_id'])
            ->with('datosRepartidor')
            ->get();
        return Datatables::of($repartidores)->make(true);
    }

    /**
     * Servicio que devuelve la tabla de los clientes de la empresa
     * @route /usuarios/clientes
     * @return mixed
     */
    public function clientes()
    {
        $clientes = User::where('tipo_usuario_id', '=', User::CLIENTE)
            ->select(['id', 'imagen_usuario', 'nombre', 'email', 'telefono'])
            ->get();
        return Datatables::of($clientes)->make(true);
    }

    /**
     * Servicio que devuelve la tabla de los administradores de la empresa
     * @route /usuarios/administradores
     * @return mixed
     */
    public function administradores()
    {
        $clientes = User::where('tipo_usuario_id', '=', User::ADMINISTRADOR)
            ->select(['id', 'imagen_usuario', 'nombre', 'email', 'telefono'])
            ->get();
        return Datatables::of($clientes)->make(true);
    }


}
