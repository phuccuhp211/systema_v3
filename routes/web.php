<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sisu_controller;
use App\Http\Controllers\cart_controller;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\admin_controller;
use App\Http\Middleware\cart;

Route::get('/', [user_controller::class, 'index'])->name('index.home');
Route::match(['get','post'] ,'/products/{type}/{data?}', [user_controller::class, 'products'])->name('index.show');

Route::get('/cart', [user_controller::class, 'cart'])->name('index.cart');
Route::get('/detail/{data}', [user_controller::class, 'detail_pd'])->name('index.detail');
Route::get('/config', [user_controller::class, 'us_config'])->name('index.con');
Route::get('/pay', [user_controller::class, 'pay'])->name('index.pay');

Route::middleware([cart::class])->group(function () {
	Route::match(['get','post'] ,'/cart/add', [cart_controller::class, 'add'])->name('cart.add');
	Route::match(['get','post'] ,'/cart/fix', [cart_controller::class, 'fix'])->name('cart.fix');
	Route::match(['get','post'] ,'/cart/del', [cart_controller::class, 'del'])->name('cart.del');
	Route::match(['get','post'] ,'/cart/dac', [cart_controller::class, 'dac'])->name('cart.dac');
});

Route::match(['get', 'post'], '/user/client/{type}', [sisu_controller::class, 'client_lls'])->name('sisu.client');
Route::match(['get', 'post'], '/user/admin/{type}', [sisu_controller::class, 'admin_lls'])->name('sisu.admin');

