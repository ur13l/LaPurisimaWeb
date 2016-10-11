<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::auth();



Route::group(['prefix' => 'usuario', 'middleware' => 'auth:api'], function () {
  Route::post('update', "UserController@update");
});

/**
 * prefijo: pedido
 * referencia: PedidoApiController
 * middleware: auth
 * Hace referencia a la parte de pedidos controlada desde la API (desde el cliente móvil).
 */
Route::group(['prefix'=>'pedido', 'middleware' => 'auth:api'], function(){
   Route::post('nuevo', 'PedidoApiController@nuevo');
   Route::post('cancelar', 'PedidoApiController@cancelar');
   Route::post('usuario', 'PedidoApiController@pedidosUsuario');
   Route::post('repartidor', 'PedidoApiController@pedidosRepartidor');
});


/**
 * prefijo: usuario
 * referencia: UserController
 * Funciones de API para el usuario. Inicio de sesión, etc.
 */
Route::group(['prefix'=>'usuario'], function(){
    Route::post('authenticate', "UserController@authenticate");
    Route::post('create', "UserController@create");
});

/**
 * prefijo: password
 * referencia: Auth\PasswordController
 * Funciones de API para el reseteo y envío de email de contraseña
 */
Route::group(['prefix'=>'password'], function(){
    Route::post('email', 'Auth\PasswordController@postEmail');
    Route::post('reset', 'Auth\PasswordController@postReset');
});

/**
 * prefijo: pedidos
 * referencia: PedidoController
 * Funciones Web para la gestión de pedidos  (No API).
 */
Route::group(['prefix' => 'pedidos'], function(){
    Route::get('/', 'PedidoController@pedidos');
    Route::get('solicitados', 'PedidoController@pedidosSolicitadosTable');
    Route::get('asignados', 'PedidoController@pedidosAsignadosTable');
    Route::get('repartidores', 'PedidoController@repartidores');
    Route::get('repartidores-json', 'PedidoController@repartidoresJSON');
    Route::get('repartidor-pedido-json', 'PedidoController@obtenerRepartidor');
    Route::get('cancelar/{pedido_id}', 'PedidoController@cancelarPedido');
    Route::get('{pedido_id}', 'PedidoController@detalle')->name('detalle');
    Route::post('asignar', 'PedidoController@asignarRepartidor');
});



Route::get('/home', 'HomeController@index');

/**
 * prefijo: pedidos
 * referencia: PedidoController
 * Funciones Web para la gestión de pedidos  (No API).
 */
Route::group(['prefix' => 'producto'], function(){
    Route::get('nuevo', 'ProductoController@nuevo');
    Route::get('editar', 'ProductoController@editar');
    Route::get('eliminar', 'ProductoController@eliminar');
    Route::post('create', "ProductoController@create");
    Route::post('update', "ProductoController@update");
    Route::get('get', "ProductoApiController@getProductos");
});

Route::get('/productos', 'ProductoController@index');

