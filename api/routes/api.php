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
Route::get('/game-data-global-view', 'GameController@gameDataGlobal');


Route::group(['middleware' => 'token'], function () {
    Route::get('/game-data', 'GameController@gameDataPlayer');
    Route::get('/get-infos', 'CodeController@getInfos');
    Route::post('/answer-question', 'AnswerController@answerQuestion');
    Route::post('/answer-performance', 'PerformanceController@answerPerformance');
    Route::post('/send-vote', 'VoteController@sendVote');
});