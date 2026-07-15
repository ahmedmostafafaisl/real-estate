<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    protected array $supported = ['ar', 'en'];

    public function handle(Request $request, Closure $next)
    {
        // API requests are stateless (Sanctum tokens, no cookies), so session()
        // would always just return its own default here — never what the client
        // actually asked for. Read the Accept-Language header instead, which is
        // what the Flutter app sends on every request.
        if ($request->is('api/*')) {
            $locale = $request->header('Accept-Language', 'ar');
        } else {
            $locale = session('locale', 'ar');
        }

        if (! in_array($locale, $this->supported)) {
            $locale = 'ar';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
