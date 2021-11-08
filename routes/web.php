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

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('guest')->group(function() {
	Route::get('/login', 'UserController@login')->name('login');
	Route::post('/login', 'UserController@postLogin')->name('postLogin');

	Route::get('/register', 'UserController@register')->name('register');
	Route::post('/register', 'UserController@postRegister')->name('postRegister');
});

Route::namespace('Customer')->name('customer.')->group(function() {
	Route::resource('produk', 'ProdukController');
	Route::resource('keranjang', 'KeranjangController');
});

Route::middleware('auth')->group(function() {
	Route::any('/logout', 'UserController@logout')->name('logout');

	Route::prefix('/admin')->middleware('role:admin')->namespace('Admin')->name('admin.')->group(function() {
		Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

		Route::resource('produk', 'ProdukController');
		Route::resource('kategori', 'KategoriController');
		Route::resource('transaksi', 'TransaksiController');
		Route::resource('user', 'UserController');
	});
});