<?php

use App\Exceptions\ExceptionsHandler;
use App\Jobs\Task\DailyTasksSummary;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {})
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e) {
            if (request()->is('api/*')) {
                return (new ExceptionsHandler)($e);
            }
        });
    })
    ->withSchedule(function ($schedule) {
        $schedule->job(new DailyTasksSummary)->daily();
    })
    ->create();
