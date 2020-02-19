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

// these two ^ v are the same but using apiResource means that individual routes should be added above it to avoid possible conflicts

Route::apiResource('cars', 'CarController');
