<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::middleware('auth')->group( function() {
    Route::get('/game/create', 'GameController@create')->name('create-game');
    Route::post('/game/create', 'GameController@createpost')->name('create-game-post');
    Route::get('/game/{game}/next-step', 'GameController@nextStep')->name('next-step');
    Route::get('/game/{game}/next-question', 'GameController@nextQuestion')->name('next-question');
    Route::get('/game/{game}/display-answer/{question}', 'GameController@displayAnswer')->name('display-answer');
    Route::get('/game/{game}/set-step1-winners', 'GameController@setStep1Winners')->name('set-step1-winners');
    Route::get('/game/{game}/set-step2-winners', 'GameController@setStep2Winners')->name('set-step2-winners');
    Route::get('/game/{game}/send-performance/{player}', 'GameController@sendPerformance')->name('send-performance');
    Route::get('/game/{game}/send-performance-props', 'GameController@sendPerformanceProps')->name('send-performance-props');
    Route::get('/game/{game}/validate-performance', 'GameController@validatePerformance')->name('validate-performance');
    Route::get('/game/{game}/send-votes', 'GameController@sendVotes')->name('send-votes');
    Route::get('/game/{game}/validate-votes', 'GameController@validateVotes')->name('validate-votes');
    Route::get('/game/{game}', 'GameController@show')->name('show-game');
    Route::get('/game/{game}/reset', 'GameController@reset')->name('reset-game');
    Route::get('/game/{game}/edit', 'GameController@edit')->name('edit-game');
    Route::post('/game/{game}/edit', 'GameController@editpost')->name('edit-game-post');
    Route::get('/game/{game}/reset-perfs', 'GameController@resetPerfs')->name('reset-perfs');

    Route::get('/question/create', 'QuestionController@create')->name('create-question');
    Route::post('/question/create', 'QuestionController@createpost')->name('create-question-post');
    Route::get('/question/{question}/edit', 'QuestionController@edit')->name('edit-question');
    Route::post('/question/{question}/edit', 'QuestionController@editpost')->name('edit-question-post');
    Route::get('/question/{question}/delete', 'QuestionController@delete')->name('delete-question');

    Route::get('/performance/create', 'PerformanceController@create')->name('create-performance');
    Route::post('/performance/create', 'PerformanceController@createpost')->name('create-performance-post');
    Route::get('/performance/{performance}/edit', 'PerformanceController@edit')->name('edit-performance');
    Route::post('/performance/{performance}/edit', 'PerformanceController@editpost')->name('edit-performance-post');
    Route::get('/performance/{performance}/delete', 'PerformanceController@delete')->name('delete-performance');
});
