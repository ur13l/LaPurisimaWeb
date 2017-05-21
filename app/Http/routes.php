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


Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {
        return view('pedidos.index');
    });
});


Route::auth();



Route::group(['prefix' => 'usuario', 'middleware' => 'auth:api'], function () {
  Route::post('update', "UserApiController@update");
});

/**
 * prefijo: usuarios
 * referencia: UserController
 * Funciones web para la gestión de usuarios (NO API).
 */
Route::group(['prefix' => 'usuarios'], function(){
    Route::get('/', 'UserController@index');
    Route::post('/repartidores', 'UserController@repartidores');
    Route::post('/clientes', 'UserController@clientes');
    Route::post('/administradores', 'UserController@administradores');
    Route::get('/nuevo/{tipo_usuario_id}', 'UserController@nuevo');
    Route::post('/create', 'UserController@create');
    Route::post('/update', 'UserController@update');
    Route::get('/{id_user}', 'UserController@detalle');
    Route::get('/editar/{id_user}', 'UserController@editar');
    Route::get('/eliminar/{id_user}', 'UserController@eliminar');
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
   Route::post('solicitados', 'PedidoApiController@obtenerPedidos');
   Route::post('asignar', 'PedidoApiController@asignarRepartidor');
   Route::post('finalizar', 'PedidoApiController@finalizarPedido');
});


/**
 * prefijo: usuario
 * referencia: UserApiController
 * Funciones de API para el usuario. Inicio de sesión, etc.
 */
Route::group(['prefix'=>'usuario'], function(){
    Route::post('authenticate', "UserApiController@authenticate");
    Route::post('create', "UserApiController@create");
    Route::post('by_phone', "UserApiController@getUserByPhone");
    Route::get('search', 'UserApiController@search');
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
    Route::get('/', 'PedidoController@pedidos')->name('index');
    Route::get('solicitados', 'PedidoController@pedidosSolicitadosTable');
    Route::get('asignados', 'PedidoController@pedidosAsignadosTable');
    Route::get('historial-pedidos', 'PedidoController@historialPedidosTable');
    Route::get('historial-envios', 'PedidoController@historialEnviosTable');
    Route::get('repartidores', 'PedidoController@repartidores');
    Route::get('repartidores-json', 'PedidoController@repartidoresJSON');
    Route::post('asignar', 'PedidoController@asignarRepartidor');
    Route::get('nuevo', 'PedidoController@nuevoPedido');
    Route::get('repartidor-pedido-json', 'PedidoController@obtenerRepartidor');
    Route::post('cancelar', 'PedidoController@cancelarPedido');
    Route::get('{pedido_id}', 'PedidoController@detalle')->name('detalle');
    Route::post('generar', 'PedidoController@generarNuevoPedido');
});



Route::get('/home', 'HomeController@index');

/**
 * prefijo: pedidos
 * referencia: PedidoController
 * Funciones Web para la gestión de pedidos  (No API).
 */
Route::group(['prefix' => 'producto'], function(){
    Route::get('nuevo', 'ProductoController@nuevo');
    Route::get('editar/{id}', 'ProductoController@editar');
    Route::get('eliminar/{id}', 'ProductoController@eliminar');
    Route::get('table', 'ProductoController@table');
    Route::post('create', "ProductoController@create");
    Route::post('update', "ProductoController@update");
    Route::get('get', "ProductoApiController@getProductos");
    Route::post('disponibilidad', "ProductoApiController@disponibilidad");
    Route::get('search', "ProductoApiController@search");
});



/**
 * prefijo: repartidor
 * referencia: RepartidorApiController
 * Funciones de API para las funcionalidades de los repartidores
 */
Route::group(['prefix' => 'repartidor'], function(){
    Route::post('status', 'RepartidorApiController@cambiarStatusRepartidor');
});


/**
 * prefijo: promociones
 * referencia: PromocionesController
 * Funciones web para la gestión de promociones de usuarios
 */
Route::group(['prefix' => 'promociones'], function(){
    Route::get('/', 'PromocionesController@index');
    Route::post('usuario', 'PromocionesController@usuario');
    Route::post('producto', 'PromocionesController@producto');
    Route::post('general', 'PromocionesController@general');
    Route::get('eliminar/{id}', 'PromocionesController@eliminar');
    Route::get('table', 'PromocionesController@table');
});


/**
 * prefijo: reportes
 * referencia: ReportesController
 * Funciones Web para las funcionalidades de los reportes
 */
Route::group(['prefix' => 'reportes'], function(){
    Route::get('/', 'ReportesController@index');
    Route::get('generar', 'ReportesController@generaExcel');
});

Route::get('/productos', 'ProductoController@index');

Route::get('/graficas', 'GraficaController@index');

Route::post('/token/register', 'NotificacionController@registrar');
