<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('auth', 'AuthController@authenticate');

Route::group(['middleware' => 'jwt.auth'], function () {
	Route::get('usuarios', 'UsuarioController@getAll')->name('getAllusuarios');
	Route::post('usuarios', 'UsuarioController@postAdd')->name('postUsuarios');
	Route::get('usuarios/{id}', 'UsuarioController@getOne')->name('getOneusuarios');
	Route::post('usuarios/{id}', 'UsuarioController@edit')->name('editUsuarios');
	Route::get('usuarios/delete/{id}', 'UsuarioController@delete')->name('deleteUsuarios');
});