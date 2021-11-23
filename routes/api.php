<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::post('persona/buscar-coincidencia', 'API\PersonaController@buscarNombre');

Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {
    // Route::post('user','API\UserController@getAuthenticatedUser');
    Route::post('persona/buscar-coincidencia', 'API\PersonaController@buscarNombre');
});