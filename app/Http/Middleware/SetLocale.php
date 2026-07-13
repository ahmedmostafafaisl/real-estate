<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    protected array $supported = ['ar', 'en'];

    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', 'ar');

        if (! in_array($locale, $this->supported)) {
            $locale = 'ar';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
