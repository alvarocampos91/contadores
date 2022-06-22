<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

JsonApi::register('default')->routes( function( $api ) {
    $api->resource('co-folios-usuarios')->only('index','read');
    $api->resource('co-folios-historial-usuarios')->only('index','read');
    $api->resource('co-folios-movimientos')->async();
    $api->resource('co-documento-movimientos')->only('index','read');
    $api->resource('co-documento-nits-asociados')->only('index','read');
    $api->resource('co-venta-movimientos')->only('index','read');
} );
