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


Route::get('/test/email', function () {

  $user = ["name" => "Pau"];

  Mail::send('admin.test', $user, function ($m) {

      $m->from('hello@app.com', 'Your Application');

      $m->to('kingpauloaquino@mail.com', 'kingpauloaquino')->subject('Your Reminder!');

  });

});

// admin page

Route::get('/members', 'AdminController@get_members');

Route::get('/members/data.json', 'AdminController@get_members_json');

Route::get('/member/usernames.json/{type?}', 'AdminController@get_members_username');

Route::get('/activation/code/lists.json', 'AdminController@get_code_lists');

Route::post('/remit/code', 'AdminController@remit_process');

// end admin page

Route::get('/genealogy', 'HomeController@genealogy');

Route::any('/genealogy/encoding/placement-validation', 'HomeController@placement_validation');

Route::get('/genealogy/encoding/{placement}/{position}/{affliliate?}', 'HomeController@encoding');

Route::post('/genealogy/member-structure-details/{member_uid?}', 'HomeController@summary_pairing');

Route::any('/genealogy/member-pairing-details/{member_uid?}', 'HomeController@summary_pairing_details');

Route::post('/referral/sign-up/{sponsor_uid}/{sponsor_muid}', 'AccountController@register_via_user_url');

Route::post('/affliate/member-lists', 'HomeController@affliate_queueing');

Route::get('/account/verified/{email}', 'AccountController@account_verified');

Route::post('/account/get-multiple-accounts', 'HomeController@get_multiple_accounts');

Route::post('/account/check/username', 'AccountController@check_username');

Route::get('/account/check-multiple', 'AccountController@check_multiple_account');

Route::get('/account/wallet/{account}', 'WalletController@get_wallet');

Route::get('/leveling', 'HomeController@leveling');

Route::any('/leveling/pairing-per-level-summary', 'HomeController@leveling_populate');


Route::get('/reset-password', 'HomeController@reset_password');

Auth::routes();

Route::get('/{username?}', 'AccountController@index');




















Route::get('/fireEvent/{type}/{account}/{description}/{timestamp}', function ($type, $account, $description, $timestamp) {
    event(new eventTrigger($type, $account, $description, $timestamp));
    return ["Status" => 200];
});

Route::get('/users-transactions', function () {
    return view('listener.userTransactions');
});
