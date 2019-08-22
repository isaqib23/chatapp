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


Route::get('/', 'HomeController@index');
Route::get('/insta_report', 'HomeController@get_insta_report');
Route::get('/youtube_report', 'YoutubeController@index');
Route::get('/get_details', 'YoutubeController@get_details');
Route::get('login/facebook', 'SocialController@redirectToProvider');
Route::get('login/facebook/callback', 'SocialController@handleProviderCallback');
Route::get('create_permissions', 'SocialController@create_permissions');
Route::get('youtube', 'SocialController@youtube');
