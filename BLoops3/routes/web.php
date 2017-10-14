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

Route::get('/fireEvent', function () {
    event(new eventTrigger());
});


Route::get('/dashboard', 'HomeController@index')->name('home');

Route::get('/account/verified/{email}', 'AccountController@account_verified');
