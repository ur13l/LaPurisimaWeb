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


Route::post('/producto/update', "ProductoController@update");
Route::group(['prefix' => 'usuario', 'middleware' => 'auth:api'], function () {
  Route::post('uploadPhoto', "UserController@uploadPhoto");
  Route::post('update', "UserController@update");
});
Route::post('/usuario/authenticate', "UserController@authenticate");
Route::post('/usuario/create', "UserController@create");

Route::auth();

Route::get('/home', 'HomeController@index');
