<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\admin_controller;

Route::get('/', [user_controller::class, 'index'] );
Route::get('/products/{page}/{data?}', [user_controller::class, 'products'] );
Route::post('/products/ajax/{page}/{data?}', [user_controller::class, 'products'] );
