<?php

namespace App\Http\Controllers;

use App\DatosRepartidor;
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

    /**
     * Función que devuelve la vista para editar los datos de un usuario.
     * @param $id_user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editar($id_user){
        $user = User::find($id_user);
        return view("usuarios.editar", ["user" => $user,  "tipo_usuario_id"=>$user->tipo_usuario_id, "action" => "update"]);

    }

    /**
     * Método para devolver la vista de formulario de edición de un nuevo usuario.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nuevo($tipo_usuario_id){
        $user = new User();
        return view("usuarios.editar", ["user" => $user, "tipo_usuario_id"=>$tipo_usuario_id, "action" => "create"]);
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


    /**
     * Método para crear a un usuario. Recibe una petición con todos
     * los datos a registrar del usuario.
     * @param  Request $request
     * @return
     */
    public function create(Request $request){
        $this->validate($request, [
            'nombre' => 'required',
            'email' => 'required|unique:users',
            'telefono' => 'required|unique:users',
            'tipo_usuario_id' => 'required',
            'password' => 'confirmed'
        ]);
        $user = User::create($request->except('imagen_usuario'));
        //$user->tipo_usuario_id = 3;

        //Se tienen que generar los datos de conductor cuando se registra un repartidor.
        if($user->tipo_usuario_id == 2){
            DatosRepartidor::create(array(
                'user_id' => $user->id,
                'latitud' => 0,
                'longitud' => 0,
                'estatus' => DatosRepartidor::INACTIVO
            ));
        }

        if ($request->hasFile('imagen')) {
            if($request->file('imagen')->isValid()){
                $extension = $request->file('imagen')->getClientOriginalExtension();
                $path = "storage/perfil/";
                $filename= $user->id . "." . $extension;
                $request->file('imagen')->move($path ,  $filename);
                $user->imagen_usuario = $path.$filename;
                $user->save();
            }
        }

        return redirect()->action('UserController@index',['message' => 'create'] );
    }

    /**
     * Función para actualizar a un usuario ya existente, se le envía como parámetro
     * un JSON con todos los campos actualizados.
     * @param  Request $request [JSON que contiene los valores de users]
     * @return [string] [JSON con success, puede ser true o false]
     */
    public function update(Request $request){
        $this->validate($request, [
            'nombre' => 'required',
            'tipo_usuario_id' => 'required',
        ]);
        $usuario = User::find($request->input('id'));
        $usuario->update($request->except(['telefono', 'email', 'id']));
        if ($request->hasFile('imagen')) {
            if($request->file('imagen')->isValid()){
                $extension = $request->file('imagen')->getClientOriginalExtension();
                $path = "storage/perfil/";
                $filename= $usuario->id . "." . $extension;
                $request->file('imagen')->move($path ,  $filename);
                $usuario->imagen_usuario = $path.$filename;
            }
        }


        return redirect()->action('UserController@index',['message' => $usuario->imagen_usuario] );
    }

}
