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
    Route::post('/profile', 'Profile\ProfileController@update')->name('profile');
    Route::get('/dashboard/invoice', 'Profile\DashboardController@index')->name('dashboard-invoice');
    Route::put('/dashboard/invoice', 'Profile\DashboardController@deleteInvoice')->name('dashboard-invoice');
    Route::get('/dashboard/salary-management', 'Profile\DashboardController@index')->name('dashboard-salary-management');

    Route::get('/invoice-gen/{cuid}', 'invoiceController@show')->name('invoice-gen');
    Route::post('/invoice', 'invoiceController@store')->name('invoice');
    Route::get('/invoice','invoiceController@index')->name('invoice');
});


