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

Route::post('/check-code', 'CodeController@checkCode');
Route::post('/login', 'CodeController@login');
Route::get('/test', function (Request $request) {
    return 'coucou';
});