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
        Route::post('change_password', 'AuthController@change_password');

        // Group Routes
        Route::post('create_group', 'GroupController@create');
        Route::post('join_group', 'GroupController@join');
        Route::post('owner_groups', 'GroupController@get_owner_groups');
        Route::post('other_groups', 'GroupController@get_other_groups');
        Route::post('groups_members', 'GroupController@get_group_users');
        Route::post('group_detail', 'GroupController@group_detail');
        Route::post('get_categories', 'GroupController@get_categories');
        Route::post('create_voucher', 'VoucherController@create');
        Route::post('get_vouchers', 'VoucherController@get_vouchers');
        Route::post('delete_voucher', 'VoucherController@delete_voucher');
        Route::post('update_group', 'GroupController@update');
        Route::post('remove_group_member', 'GroupController@remove_group_member');
        Route::post('update_group_member', 'GroupController@update_group_member');

        //Stripe Routes
        Route::post('get_stripe_settings', 'ApiController@get_stripe_settings');
        Route::post('cancel_subscription', 'ApiController@cancel_subscription');
        Route::post('get_subscriptions', 'ApiController@get_subscriptions');
        Route::post('get_payment_history', 'ApiController@get_payment_history');

        // Messages Routes
        Route::post('send_message', 'MessageController@create');
        Route::post('get_messages', 'MessageController@get_messages');
        Route::post('get_single_conversation', 'MessageController@get_single_conversation');
        Route::post('get_group_conversation', 'MessageController@get_group_conversation');
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
