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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::post('logout', 'AuthController@logout');
        Route::post('user', 'AuthController@user');
        Route::post('update_profile', 'AuthController@update');

        // Group Routes
        Route::post('create_group', 'GroupController@create');
        Route::post('join_group', 'GroupController@join');
        Route::post('owner_groups', 'GroupController@get_owner_groups');
        Route::post('groups_members', 'GroupController@get_group_users');
        Route::post('group_detail', 'GroupController@group_detail');
        Route::post('get_categories', 'GroupController@get_categories');
    });
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('forgot_password', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});
