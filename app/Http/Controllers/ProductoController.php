<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Producto;
use Auth;

class ProductoController extends Controller
{

    /**
     * Llamada inicial de productos, muestra la vista de los productos para ser mostrados.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
  public function index(Request $request){
    if(Auth::user()){
      if(Auth::user()->tipo_usuario_id == 1) {
          $productos = Producto::paginate(10);
          return view('productos.lista', ['productos' => $productos, 'message' => $request->message]);
      }
    }
    return redirect()->action('HomeController@index');
  }

    /**
     * Método que devuelve la vista con el formulario para un nuevo producto.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
  public function nuevo(){
    if(Auth::user()){
      if(Auth::user()->tipo_usuario_id == 1)
        return view('productos.form', ['action' => 'create','producto' => new Producto()]);
    }
    return redirect()->action('HomeController@index');
  }

    /**
     * Se devuelve la vista para el formulario para editar un producto.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
  public function editar(Request $request){
    if(Auth::user()){
        if(Auth::user()->tipo_usuario_id == 1)
            return view('productos.form', ['action' => 'update', 'producto' => Producto::find($request->input('id'))]);
    }
    return redirect()->action('HomeController@index');
  }

    /**
     * Método de eliminar, recibe una petición con el ID del elemento a eliminar y realiza un soft delete.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminar(Request $request){
        if(Auth::user()){
            if(Auth::user()->tipo_usuario_id == 1){
                $producto = Producto::find($request->input('id'));
                $producto->delete();
            }
        }
        return redirect()->action('ProductoController@index', ['message' => 'delete']);
    }



  /**
   * Función utilizada para crear un nuevo producto.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request){
    $this->validate($request, [
       'nombre' => 'required',
       'stock' => 'required|numeric|min:0|max:100000000',
       'contenido' => 'required|numeric|min:0|max:10000000',
       'precio' => 'required|numeric|min:0.01|max:10000000',
       'imagen' => 'required'
   ]);

    if(Auth::user()){
      if(Auth::user()->tipo_usuario_id == 1){
        $producto = Producto::create($request->except('imagen'));
        if ($request->hasFile('imagen')) {
          if($request->file('imagen')->isValid()){
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $path = "storage/productos/";
            $filename= $producto->id . "." . $extension;
            $request->file('imagen')->move($path ,  $filename);
            $producto->imagen = $path.$filename;
            $producto->save();
          }
        }
      }
    }
    return redirect()->action('ProductoController@index',['message' => 'create'] );
  }

  /**
   * Función utilizada para crear un nuevo producto.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request){
    $this->validate($request, [
       'nombre' => 'required',
       'stock' => 'required|numeric|min:0|max:100000000',
       'contenido' => 'required|numeric|min:0|max:10000000',
       'precio' => 'required|numeric|min:0.01|max:10000000'
   ]);

    if(Auth::user()){
      if(Auth::user()->tipo_usuario_id == 1){
        $producto = Producto::find($request->input('id'));
        $producto->update($request->except('imagen'));
        if ($request->hasFile('imagen')) {
          if($request->file('imagen')->isValid()){
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $path = "storage/productos/";
            $filename= $producto->id . "." . $extension;
            $request->file('imagen')->move($path ,  $filename);
            $producto->imagen = $path.$filename;
            $producto->save();
          }
        }
        $producto->save();
      }
    }
    return redirect()->action('ProductoController@index', ['message' => 'update']);
  }

}
