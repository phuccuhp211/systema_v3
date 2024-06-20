<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\sisu_controller;
use App\Http\Controllers\Client\cart_controller;
use App\Http\Controllers\Client\user_controller;
use App\Http\Controllers\Client\pay_controller;
use App\Http\Controllers\Admin\admin_controller;
use App\Http\Controllers\Client\pmmt_controller;

use App\Http\Middleware\cart;
use App\Http\Middleware\payment;
use App\Http\Middleware\adminlog;

Route::get('/', [user_controller::class, 'index'])->name('home');
Route::match(['get','post'] ,'/products/{type}/{data?}', [user_controller::class, 'products'])->name('show');
Route::get('/cart', [user_controller::class, 'cart'])->name('cart');
Route::get('/detail/{data}', [user_controller::class, 'detail'])->name('detail');
Route::get('/config', [user_controller::class, 'config'])->name('config');
Route::get('/pay', [user_controller::class, 'pay'])->name('pay');
Route::get('/complete_order', [user_controller::class, 'dord'])->name('dord');
Route::get('/reset_password', [user_controller::class, 'rspw'])->name('rspw');
Route::match(['get','post'] ,'/invoice_check', [user_controller::class, 'inv_check'])->name('invoice');
Route::post('/comment', [user_controller::class, 'comment'])->name('cmt');
Route::post('/rating', [user_controller::class, 'rate'])->name('rate');

Route::middleware([payment::class])->group(function () {
	Route::post('/payment/checkip', [pay_controller::class, 'validation'])->name('payment.vli');
	Route::post('/payment/addcp', [pay_controller::class, 'applycoupon'])->name('payment.dcp');
	Route::post('/payment/order', [pay_controller::class, 'order'])->name('payment.ord');
	Route::post('/payment/store', [pay_controller::class, 'store'])->name('payment.str');
});

Route::middleware([cart::class])->group(function () {
	Route::get('/cart/buy/{id}', [cart_controller::class, 'buy'])->name('cart.buy');
	Route::post('/cart/add', [cart_controller::class, 'add'])->name('cart.add');
	Route::post('/cart/fix', [cart_controller::class, 'fix'])->name('cart.fix');
	Route::post('/cart/del', [cart_controller::class, 'del'])->name('cart.del');
	Route::post('/cart/dac', [cart_controller::class, 'dac'])->name('cart.dac');
});

Route::match(['get', 'post'], '/user/client/{type}', [sisu_controller::class, 'client_lls'])->name('client');
Route::match(['get', 'post'], '/user/admin/{type}', [sisu_controller::class, 'admin_lls'])->name('admin');

Route::get('/admin', [admin_controller::class, 'login'])->name('alog');
Route::middleware([adminlog::class])->group(function () {
	Route::match(['get','post'] ,'/manager/{type?}', [admin_controller::class, 'manager'])->name('manager');
	Route::match(['get','post'] ,'manager/ss/{type}/{id?}', [admin_controller::class, 'ss_mng'])->name('manager.ss');
	Route::match(['get','post'] ,'manager/bn/{type}/{id?}', [admin_controller::class, 'bn_mng'])->name('manager.bn');
	Route::match(['get','post'] ,'manager/pd/{type}/{id?}', [admin_controller::class, 'pd_mng'])->name('manager.pd');
	Route::match(['get','post'] ,'manager/c1/{type}/{id?}', [admin_controller::class, 'c1_mng'])->name('manager.c1');
	Route::match(['get','post'] ,'manager/c2/{type}/{id?}', [admin_controller::class, 'c2_mng'])->name('manager.c2');
	Route::match(['get','post'] ,'manager/us/{type}/{id?}', [admin_controller::class, 'us_mng'])->name('manager.us');
	Route::match(['get','post'] ,'manager/cm/{type}/{id?}', [admin_controller::class, 'cm_mng'])->name('manager.cm');
	Route::match(['get','post'] ,'manager/in/{type}/{id?}', [admin_controller::class, 'in_mng'])->name('manager.in');
	Route::match(['get','post'] ,'manager/cp/{type}/{id?}', [admin_controller::class, 'cp_mng'])->name('manager.cp');
	Route::post('/manager/filter', [cart_controller::class, 'filter'])->name('manager.filter');
});

Route::post('/vnpay_payment', [pmmt_controller::class, 'vnpay_payment'])->name('vnpay.payment');
Route::get('/vnpay_result', [pmmt_controller::class, 'vnpay_result'])->name('vnpay.result');