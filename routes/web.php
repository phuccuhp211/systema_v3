<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sisu_controller;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\admin_controller;

Route::match(['get','post'] ,'/', [user_controller::class, 'index'])->name('index.home');
Route::match(['get','post'] ,'/products/{type}/{data?}', [user_controller::class, 'products'])->name('index.show');
Route::get('/detail/{data}', [user_controller::class, 'detail_pd'])->name('index.detail');
Route::get('/config', [user_controller::class, 'us_config'])->name('index.con');

Route::match(['get', 'post'], '/user/client/{type}', [sisu_controller::class, 'client_lls'])->name('sisu.client');
Route::match(['get', 'post'], '/user/admin/{type}', [sisu_controller::class, 'admin_lls'])->name('sisu.admin');

