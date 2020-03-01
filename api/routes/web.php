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
    Route::get('/game/{game}/next-step', 'GameController@nextStep')->name('next-step');
    Route::get('/game/{game}/next-question', 'GameController@nextQuestion')->name('next-question');
    Route::get('/game/{game}/set-step1-winners', 'GameController@setStep1Winners')->name('set-step1-winners');
    Route::get('/game/{game}/set-step2-winners', 'GameController@setStep2Winners')->name('set-step2-winners');
    Route::get('/game/{game}/send-performance/{player}', 'GameController@sendPerformance')->name('send-performance');
    Route::get('/game/{game}/send-performance-props', 'GameController@sendPerformanceProps')->name('send-performance-props');
    Route::get('/game/{game}/validate-performance', 'GameController@validatePerformance')->name('validate-performance');
    Route::get('/game/{game}/send-votes', 'GameController@sendVotes')->name('send-votes');
    Route::get('/game/{game}', 'GameController@show');
    Route::get('/game/{game}/reset', 'GameController@reset')->name('reset-game');
    Route::get('/game/{game}/reset-perfs', 'GameController@resetPerfs')->name('reset-perfs');
});