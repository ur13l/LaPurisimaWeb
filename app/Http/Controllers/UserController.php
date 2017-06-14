<?php

namespace App\Http\Controllers;

use App\DatosRepartidor;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Producto;

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
            ->select(['id', 'imagen_usuario', 'nombre', 'email', 'telefono', 'telefono_casa'])
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
            ->select(['id', 'imagen_usuario', 'nombre', 'email', 'telefono', 'telefono_casa'])
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
                $filename= uniqid("usuario_") . "." . $extension;
                $request->file('imagen')->move($path ,  $filename);
                $user->imagen_usuario = url($path.$filename);
                $user->save();
            }
        }

        if($request->has('url_usuario')){
            $user->imagen_usuario = $request->input('url_usuario');
            $user->save();
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
        $usuario->update($request->except(['telefono', 'email', 'id', 'imagen_usuario']));
        if ($request->hasFile('imagen')) {
            if($request->file('imagen')->isValid()){
                ImageController::eliminarImagen($usuario->imagen_usuario);
                $extension = $request->file('imagen')->getClientOriginalExtension();
                $path = "storage/perfil/";
                $filename= uniqid("usuario_") . "." . $extension;
                $request->file('imagen')->move($path ,  $filename);
                $usuario->imagen_usuario = url($path.$filename);
                $usuario->save();
            }
        }

        if($request->has('url_usuario')){
            ImageController::eliminarImagen($usuario->imagen_usuario);

            $usuario->imagen_usuario = $request->input('url_usuario');
            $usuario->save();
        }

        return redirect()->action('UserController@index',['message' => 'update'] );
    }

    /**
     * Función para eliminar a un usuario.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminar($id){
        //Se busca el id del usuario. Antes de eliminar se deben quitar sus referencias.
        $usuario = User::find($id);

        ImageController::eliminarImagen($usuario->imagen_usuario);

        $usuario->delete();
        return redirect()->action('UserController@index',['message' => 'deleted'] );
    }


public function stockRepartidor($id) {
  $usuario = User::find($id);
  $dr = $usuario->datosRepartidor;
  $productos = Producto::where('stock', '>', '0')->get();
  if(isset($dr)) {
    return view('usuarios.stock', ['user' =>$usuario, 'productos' => $productos]);
  }

  return redirect()->action('UserController@index' );

}


public function actualizarStockRepartidor (Request $request) {
  $user = User::find($request->id);
  $items = $request->productos;
  $band = true;
  $errors = [];
  foreach($items as $item) {
    if(!$this->tieneStock($item['cantidad'], $item['id'], $user)){
      $band = false;
      $producto = Producto::find($item['id']);
      $errors[] = "No hay suficiente stock del producto " . $producto->nombre . ", solo hay ". $producto->stock . " disponibles.";
    }
  }

  if($band) {
    $this->updateStock($items, $user);
    return response()->json([
      'success' => true,
      'errors' => $errors
    ]);
  }
  return response()->json([
    'success' => false,
    'errors' => $errors
  ]);
}

private function tieneStock($cantidad, $idProducto, $usuario) {
  $producto = Producto::find($idProducto);
  $stockActual = $usuario->datosRepartidor->productos->find($idProducto);
  if(isset($stockActual)) {
    $cantidad = $cantidad - $stockActual->pivot->cantidad;
  }
  else {
    $cantidad = $cantidad;
  }
  if ($producto->stock >= $cantidad ){
    return true;
  }
  return false;
}


private function updateStock($items, $user) {
  foreach($items as $item) {
    $producto = Producto::find($item['id']);
    $stockActual = $user->datosRepartidor->productos->find($item['id']);
    if(isset($stockActual)) {
      $cantidad = $item['cantidad'] - $stockActual->pivot->cantidad;
    }
    else {
      $cantidad = $item['cantidad'];
    }
    if ($producto->stock >= $cantidad ){
      $producto->stock -= $cantidad;
      $producto->save();
      if(isset($stockActual)) {

        $user->datosRepartidor->productos()->updateExistingPivot($item['id'], ['cantidad' => $stockActual->pivot->cantidad + $cantidad]);
        $user->datosRepartidor->save();
      }
      else {
        $user->datosRepartidor->productos()->attach($item['id']);
        $user->datosRepartidor->productos()->updateExistingPivot($item['id'], ['cantidad' => $cantidad]);
        $user->datosRepartidor->save();
      }
    }
  }
}

}
