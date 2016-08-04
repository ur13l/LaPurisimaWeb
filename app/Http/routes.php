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




Route::get('/photo', function(){
  return view('pruebaPhoto');
});

Route::post('/producto/update', "ProductoController@update");

Route::post('/usuario/update', "UserController@update");
Route::post('/usuario/authenticate', "UserController@authenticate");
Route::post('/usuario/create', "UserController@create");
Route::post('/usuario/uploadPhoto', "UserController@uploadPhoto");
