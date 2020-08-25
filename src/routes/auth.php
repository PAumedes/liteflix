<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register AUTH routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "auth" middleware group.
|
*/

Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('sign_up', 'Auth\RegisterController@signUp')->name('sing_up');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('refresh', 'Auth\LoginController@refresh')->name('refresh');
Route::post('me', 'Auth\LoginController@me')->name('me');
Route::get('sign-in/facebook', 'Auth\LoginController@facebook');
Route::get('sign-in/facebook/redirect', 'Auth\LoginController@facebookRedirect');
Route::get('sign-in/google', 'Auth\LoginController@google');
Route::get('sign-in/google/redirect', 'Auth\LoginController@googleRedirect');


