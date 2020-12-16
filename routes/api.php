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

Auth::routes();
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::resource('users', 'UserController');
Route::post('user/nip', 'UserController@updateNip');
Route::post('user/password', 'UserController@updatePassword');
Route::post('contact_form', 'UserController@contactForm');
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::get('user/rechargues/{id}', 'UserController@userRechargues');
Route::get('user/rechargue/oxxo/{id}', 'UserController@oxxoPaymentDetail');

Route::resource('wallets', 'WalletsController');
Route::get('balances/{id}', 'WalletsController@balances');
Route::post('fund', 'WalletsController@fund');
Route::post('withdraw', 'WalletsController@withdraw');
Route::post('trade', 'WalletsController@trade');
Route::post('transfer', 'WalletsController@transfer');
Route::post('getWallets', 'WalletsController@getWallets');

Route::resource('coins', 'CoinsController');
Route::get('coins_info', 'CoinsController@coinsInfo');

Route::resource('history', 'HistoryController');

// OneSignal Routes for API Endpoints
Route::resource('onesignal', 'OneSignalController');

Route::resource('conekta', 'ConektaController');

Route::post('conekta/oxxoPayment','ConektaController@oxxoPayment');
Route::post('conekta/cardPayment','ConektaController@cardPayment');
Route::post('conekta/addCard','ConektaController@addCard');
Route::post('conekta/destroyCard','ConektaController@destroyCard');
Route::get('conekta/getCardsByUser/{id}','ConektaController@getCardsByUser');
Route::post('conekta/addPaymentMethod','ConektaController@addPaymentMethod');

Route::post('conekta/addCustomer','ConektaController@addCustomer');

Route::resource('faqs', 'FAQsController');
