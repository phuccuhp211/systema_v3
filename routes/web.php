<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sisu_controller;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\admin_controller;

Route::match(['get','post'] ,'/', [user_controller::class, 'index'])->name('index');
Route::match(['get','post'] ,'/products/{type}/{data?}', [user_controller::class, 'products'])->name('products.show');
Route::get('/detail/{data}', [user_controller::class, 'detail_pd'])->name('products.detail');
Route::post('/login', [sisu_controller::class, 'client_login'])->name('sisu.in');
Route::get('/logout', [sisu_controller::class, 'client_logout'])->name('sisu.out');
Route::post('/regis', [sisu_controller::class, 'client_regis'])->name('sisu.reg');
