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

use App\Events\eventTrigger;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/genealogy', 'HomeController@genealogy');

Route::post('/genealogy/encoding', 'HomeController@encoding');

Route::get('/account/verified/{email}', 'AccountController@account_verified');

























Route::get('/fireEvent/{type}/{account}/{description}/{timestamp}', function ($type, $account, $description, $timestamp) {
    event(new eventTrigger($type, $account, $description, $timestamp));
    return ["Status" => 200];
});

Route::get('/users-transactions', function () {
    return view('listener.userTransactions');
});
