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

Route::group(['middleware' => 'token'], function () {
    Route::get('/game-data', 'GameController@gameData');
    Route::get('/get-infos', 'CodeController@getInfos');
    Route::post('/answer-question', 'AnswerController@answerQuestion');
});