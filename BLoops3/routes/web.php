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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/fireEvent/{type}/{account}/{description}/{timestamp}', function ($type, $account, $description, $timestamp) {

  // for($i = 0; $i = 1000; $i++) {
  //
  // }

    event(new eventTrigger($type, $account, $description, $timestamp));

    return ["Status" => 200];
});

Route::get('/users-transactions', function () {
    return view('listener.userTransactions');
});


Route::get('/dashboard', 'HomeController@index');

Route::get('/genealogy', 'HomeController@genealogy');

Route::get('/account/verified/{email}', 'AccountController@account_verified');
