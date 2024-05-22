<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\admin_controller;

Route::get('/', [user_controller::class, 'index'] );
Route::get('/products/{page}/{data?}', [user_controller::class, 'products'] );
Route::post('/ajax/{page}', [user_controller::class, 'ajax_hl'] );
