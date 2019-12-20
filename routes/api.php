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


Route::group(['middleware' => ['cors']], function () {
    Route::apiResource('contas', 'ContaController');
    Route::post('login', 'AuthController@login');
});

Route::apiResource('bancos', 'BancoController');
Route::apiResource('fluxos', 'FluxoController');
Route::apiResource('lancamentos', 'LancamentoController');
Route::apiResource('titulos', 'TituloController');
Route::apiResource('cedentes', 'CedenteController');



Route::post('register', 'AuthController@register');


