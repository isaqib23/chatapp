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


use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    // return what you want
});

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/groups', 'GroupController@index')->name('groups');
Route::get('/group_owners', 'UserController@group_owners')->name('group_owners');
Route::get('/members', 'UserController@members')->name('members');
Route::match(array('GET','POST'),'categories', 'GroupController@categories')->name('categories');
