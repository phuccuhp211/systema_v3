<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\admin_controller;

Route::match(['get','post'] ,'/', [user_controller::class, 'index']);
Route::match(['get','post'] ,'/products/{type}/{data?}', [user_controller::class, 'products'])->name('products.show');
Route::get('/detail/{data}', [user_controller::class, 'detail_pd'])->name('products.detail');
