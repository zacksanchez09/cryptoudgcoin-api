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

Route::get('/', function () {
    return view('landing.index');
});

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
  Route::get('/', 'HomeController@index');
  Route::resource('users', 'UsersController');
  Route::get('transactions', 'HistoryController@getTransactions');
  Route::get('user/transactions/{id}', 'HistoryController@userTransactions')->name('user_transactions');
  Route::get('charts', 'HistoryController@getCharts');
  Route::get('wallets', 'WalletsController@getAllWallets');
  Route::get('funds', 'UserController@allFunds');
  Route::resource('faqs', 'FAQsController');
  Route::get('faqs', 'FAQsController@getFaqs');
});
