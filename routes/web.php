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



Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/groups', 'GroupController@index')->name('groups');
Route::get('/group_owners', 'UserController@group_owners')->name('group_owners');
Route::get('/members', 'UserController@members')->name('members');

