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

Route::group(['prefix'=>'pedido', 'middleware' => 'auth:api'], function(){
   Route::post('nuevo', 'PedidoApiController@nuevo');
   Route::post('cancelar', 'PedidoApiController@cancelar');
});

Route::post('/usuario/authenticate', "UserController@authenticate");
Route::post('/usuario/create', "UserController@create");

Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('password/test', function(){
  return view('auth.emails.password');
});


Route::get('/pedidos', 'PedidoController@pedidos');
Route::get('/pedidos/data', 'PedidoController@getRowDetailsData');
Route::get('/home', 'HomeController@index');
Route::get('/productos', 'ProductoController@index');
Route::get('/producto/nuevo', 'ProductoController@nuevo');
Route::get('/producto/editar', 'ProductoController@editar');
Route::get('/producto/eliminar', 'ProductoController@eliminar');
Route::post('/producto/create', "ProductoController@create");
Route::post('/producto/update', "ProductoController@update");
