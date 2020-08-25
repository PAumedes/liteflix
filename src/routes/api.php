<?php

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

Route::group(['prefix' => 'movies'], function () {
    Route::get('now_playing', 'MovieController@nowPlaying');
    Route::get('upcoming', 'MovieController@upcoming');
    Route::get('popular', 'MovieController@popular');
    Route::get('highlight', 'MovieController@highlight');
    Route::post('upload_poster', 'MovieController@uploadPoster');
    Route::get('index', 'MovieController@index');
    Route::post('create', 'MovieController@create');
});

Route::group(['prefix' => 'genres'], function () {
    Route::get('index', 'GenreController@index');
});
