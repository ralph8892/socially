<?php

use App\Mail\RecapEmail;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'mustBeLoggedIn' => \App\Http\Middleware\MustBeLoggedIn::class
        ]);
    })

    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(new RecapEmail)->everyMinute();
        // Run artisan command: php artisan schedule:work when on a dev environment
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
