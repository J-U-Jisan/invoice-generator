<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function (){
    Route::get('/profile', 'Profile\ProfileController@index')->name('profile');
    Route::get('/dashboard', 'Profile\DashboardController@index')->name('dashboard');

    Route::post('/invoice-gen', 'invoiceController@store')->name('invoice-gen');
    Route::get('/invoice','invoiceController@index')->name('invoice');
});


