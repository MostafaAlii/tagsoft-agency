<?php

use Core\Exceptions\CustomExceptionHandler;
use Core\Http\Middleware\JwtGuardMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\{Exceptions,Middleware};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'jwt.custom' => JwtGuardMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        (new CustomExceptionHandler())->register($exceptions);
    })->create();