<?php

namespace App\Http\Controllers;

use App\Pedido;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\User;
use App\Http\Controllers\ImageController;
use Carbon\Carbon;
use Mail;
use Validator;

class UserApiController extends Controller
{
  /**
   * Método para crear a un usuario. Recibe una petición con todos
   * los datos a registrar del usuario.
   * @param  Request $request [JSON que contiene los valores de users]
   * @return [string] [JSON con success, puede ser true o false]
   */
  public function create(Request $request){
    $rules = array('email' => 'unique:users,email');
    $validator = Validator::make($request->all(), $rules);
    $errors = [];
      $success = true;
    if ($validator->fails()) {
      $success = false;
      $errors[] = "email.exists";
    }
    else{
        $user = User::create($request->except('imagen_usuario'));
        $user->tipo_usuario_id = 3;
        $user->save();
        $data = $request->input('imagen_usuario');
        if(isset($data)) {
            $route = "/storage/perfil/";

            $user->imagen_usuario = url(ImageController::saveImage($data, $route, uniqid("usuario_")));
            $success = $user->save();
        }
        if($request->has('url_usuario')){
            $user->imagen_usuario = $request->input('url_usuario');
            $user->save();
        }
    }
    return response()->json([
      "success" => var_export($success, true),
      "error" => $errors
    ]);
  }

  /**
   * Función para actualizar a un usuario ya existente, se le envía como parámetro
   * un JSON con todos los campos actualizados.
   * @param  Request $request [JSON que contiene los valores de users]
   * @return [string] [JSON con success, puede ser true o false]
   */
  public function update(Request $request){
    $usuario = Auth::guard('api')->user();
    $saved = false;
    if($usuario->exists()){


        $data = explode(',', $request->input('imagen_usuario'));


        if(count($data) > 1 && base64_decode($data[1])){
        $usuario->update($request->except('imagen_usuario'));
        $data = $request->input('imagen_usuario');
        $route = "storage/perfil/";
          $is64 = true;
          ImageController::eliminarImagen($usuario->imagen_usuario);

          $usuario->imagen_usuario = url(ImageController::saveImage($data, $route, uniqid("usuario_")));
      }
      else{
        $is64 = false;
        if($request->has('url_usuario')){
            $usuario->imagen_usuario = $request->input('url_usuario');
        }
        $usuario->update($request->all());
      }

      $saved = $usuario->save();
    }
    return response()->json([
      "success" => $saved,
        "is64" => $is64
    ]);
  }

  /**
   * Método de autenticación de usuario, recibe el email y password
   * que compara contra la base de datos y devuelve la instancia correcta
   * de User o un error.
   * @param  Request $request [JSON con email y password]
   * @return [User]           [Devuelve el usuario logueado]
   */
  public function authenticate(Request $request){
    $email = $request->input('email');
    $password = $request->input('password');
    $errors = ["bad.login"];
    if (Auth::once(['email' => $email, 'password' => $password ])) {
      return Auth::user();
    }

    return response()->json([
      "success"=>"false",
      "error" => $errors
    ]);
  }

  /**
   * [uploadPhoto description]
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function uploadImage(Request $request){
    $file = $request->file('imagen_usuario');
    $id = $request->input('id');
    if ($file->isValid()) {
      $destinationPath = "img";
      $file->move($destinationPath, $id . $file->getClientOriginalExtension());
      return response()->json([
        "success" => "true"
      ]);
    }
    return response()->json([
      "success" => "false"
    ]);
  }

  public function getUserByPhone(Request $request){
      $phone = $request->input('telefono');
      $user = User::where('telefono', '=', $phone)->select('id', 'nombre', 'telefono', 'telefono_casa', 'email', 'calle', 'colonia', 'referencia', 'imagen_usuario')->first();
      if(isset($user)){
          $ultPedido = Pedido::where("cliente_id", "=", $user->id)->orderBy('fecha','desc')->select('direccion','latitud', 'longitud', 'tipo_pago_id', 'cantidad_pago')->first();

          return response()->json(array(
              "user"=>$user,
              "ultimo_pedido" => $ultPedido
          ));
      }

      return response()->json();
  }

    /**
     * Método para devolver el contenido de una búsqueda de usuarios
     * @param Request $request
     */
    public function search(Request $request){
        $q = $request->q;
        $page = $request->page;
        $usuarios = User::where("nombre", 'like', "%$q%")
            ->orWhere("telefono", "like", "%$q%")
            ->orWhere('email', "like", "%$q%")
            ->orWhere('telefono_casa', "like", "%$q%")
            ->paginate($page);
        return $usuarios;
    }

}
