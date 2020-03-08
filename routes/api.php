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

// Route::get('/cars', 'CarController@index');
// Route::delete('/cars/{caR}', 'CarController@destroy');
// Route::post('/cars', 'CarController@store');
// Route::put('/cars/{car}', 'CarController@update');

// after using apiResource individual routes should be added above apiResource to avoid conflict

Route::apiResource('cars', 'CarController');
Route::apiResource('rooms', 'RoomController');
Route::apiResource('users', 'UserController');
