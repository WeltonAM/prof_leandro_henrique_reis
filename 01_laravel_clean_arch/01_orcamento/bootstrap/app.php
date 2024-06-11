<?php

use App\Http\Middleware\OrganizationMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    if (!defined('SIGINT')) {
        define('SIGINT', 2);
    }
    if (!defined('SIGTERM')) {
        define('SIGTERM', 15);
    }
    if (!defined('SIGHUP')) {
        define('SIGHUP', 1);
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(OrganizationMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
