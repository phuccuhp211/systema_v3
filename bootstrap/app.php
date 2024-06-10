<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\checklog;
use App\Http\Middleware\rspw_expiry;
use App\Http\Middleware\cart;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [rspw_expiry::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
