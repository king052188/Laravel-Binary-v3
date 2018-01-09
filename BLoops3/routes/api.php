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


Route::get('/get/non-synched-member', 'ApiController@get_non_synched_member');

Route::get('/update/member-synched/{uid}', 'ApiController@update_to_synched_status');

//

Route::any('/v1/sms/send', 'ApiController@post_sms');

Route::get('/get/sms-queue', 'ApiController@get_sms');

Route::get('/get/load-queue', 'ApiController@get_load_queue');

Route::get('/update/sms-queue/{id}', 'ApiController@update_sms');

Route::get('/update/load-queue/{id}/{status}/{message}', 'ApiController@update_load_queue');
