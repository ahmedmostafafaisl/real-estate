<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Required by routes/api.php, which protects the provider/admin
        // route groups with ->middleware('role:service_provider' / 'role:admin')
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
        ]);

        // Applies the session-stored locale (ar by default) to every web request.
        $middleware->web(append: [
            SetLocale::class,
        ]);

        // Same middleware, but for API requests it reads the Accept-Language
        // header instead of session (see SetLocale::handle) — the Flutter app
        // sends that header on every call.
        $middleware->api(append: [
            SetLocale::class,
        ]);

        // Stripe's webhook is a server-to-server POST with no session/CSRF token —
        // it's verified instead by its own signature check in StripeWebhookController.
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
