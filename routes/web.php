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
Route::get('youtube/login', 'YoutubeController@log')->name('youtube.login');
Route::get('youtube/callback', 'YoutubeController@callback')->name('youtube.callback');
Route::get('/videos', 'VideoController@index')->name('video.index');
