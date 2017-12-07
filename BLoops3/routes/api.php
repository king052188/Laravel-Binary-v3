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

Route::get('/get/sms-queue', 'ApiController@get_sms');

Route::get('/update/sms-queue/{id}', 'ApiController@update_sms');
