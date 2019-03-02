<?php

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

Route::post('qr/generate', 'API\QrCodeController@generate');
Route::get('qr/{hash}', 'API\QrCodeController@getByHash');
Route::put('qr/status/{hash}', 'API\QrCodeController@setStatusByHash');