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



Route::get('/genealogy', 'HomeController@genealogy');

Route::get('/genealogy/encoding/{placement}/{position}', 'HomeController@encoding');

Route::get('/genealogy/pairing-referral-summary', 'HomeController@summary_pairing');

Route::get('/account/verified/{email}', 'AccountController@account_verified');

Route::post('/account/check/username', 'AccountController@check_username');

Route::get('/account/check-multiple', 'AccountController@check_multiple_account');

Route::get('/account/wallet/{account}', 'WalletController@get_wallet');


Auth::routes();

Route::get('/{username?}', 'HomeController@index');




















Route::get('/fireEvent/{type}/{account}/{description}/{timestamp}', function ($type, $account, $description, $timestamp) {
    event(new eventTrigger($type, $account, $description, $timestamp));
    return ["Status" => 200];
});

Route::get('/users-transactions', function () {
    return view('listener.userTransactions');
});
