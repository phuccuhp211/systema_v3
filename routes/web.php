<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\sisu_controller;
use App\Http\Controllers\Client\cart_controller;
use App\Http\Controllers\Client\user_controller;
use App\Http\Controllers\Client\pay_controller;
use App\Http\Controllers\Admin\admin_controller;

use App\Http\Middleware\cart;
use App\Http\Middleware\payment;

Route::get('/', [user_controller::class, 'index'])->name('home');
Route::match(['get','post'] ,'/products/{type}/{data?}', [user_controller::class, 'products'])->name('show');

Route::get('/cart', [user_controller::class, 'cart'])->name('cart');
Route::get('/detail/{data}', [user_controller::class, 'detail_pd'])->name('detail');
Route::get('/config', [user_controller::class, 'us_config'])->name('config');
Route::get('/pay', [user_controller::class, 'pay'])->name('pay');

Route::middleware([payment::class])->group(function () {
	Route::post('/payment/checkip', [pay_controller::class, 'vli'])->name('payment.vli');
	Route::post('/payment/appcp', [pay_controller::class, 'dcp'])->name('payment.dcp');
	Route::post('/payment/order', [pay_controller::class, 'ord'])->name('payment.ord');
});

Route::middleware([cart::class])->group(function () {
	Route::match(['get','post'] ,'/cart/add', [cart_controller::class, 'add'])->name('cart.add');
	Route::match(['get','post'] ,'/cart/fix', [cart_controller::class, 'fix'])->name('cart.fix');
	Route::match(['get','post'] ,'/cart/del', [cart_controller::class, 'del'])->name('cart.del');
	Route::match(['get','post'] ,'/cart/dac', [cart_controller::class, 'dac'])->name('cart.dac');
});

Route::match(['get', 'post'], '/user/client/{type}', [sisu_controller::class, 'client_lls'])->name('client');
Route::match(['get', 'post'], '/user/admin/{type}', [sisu_controller::class, 'admin_lls'])->name('admin');

