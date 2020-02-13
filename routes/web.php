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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('videos', 'VideoController')->only([
        'index',
        'store',
        'destroy'
    ]);

    Route::group(['middleware' => 'isLeader'], function () {
        Route::get('youtube', 'YoutubeController@index')->name('youtube.index');
        Route::get('youtube/login', 'YoutubeController@login')->name('youtube.login');
        Route::get('youtube/callback', 'YoutubeController@callback')->name('youtube.callback');
    });
});


