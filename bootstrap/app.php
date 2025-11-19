<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //check if user is authenticated /dashboard
        //redirect to login page if not authenticated
        //check if user is permitted to use access that page
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
