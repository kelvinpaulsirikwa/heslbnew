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
        $middleware->web([
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\LogUniqueVisits::class,
            \App\Http\Middleware\PreventBlockedUserActions::class,
            \App\Http\Middleware\LoginAttemptLimiter::class,
            \App\Http\Middleware\EnforcePasswordChange::class,
            \App\Http\Middleware\PreventBackButton::class,
            \App\Http\Middleware\CheckUserStatus::class,
        ]);

        $middleware->alias([
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'prevent.back.button' => \App\Http\Middleware\PreventBackButton::class,
            'prevent.blocked.actions' => \App\Http\Middleware\PreventBlockedUserActions::class,
            'check.user.status' => \App\Http\Middleware\CheckUserStatus::class,
            'login.attempt.limiter' => \App\Http\Middleware\LoginAttemptLimiter::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
