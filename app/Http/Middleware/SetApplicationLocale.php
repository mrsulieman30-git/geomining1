<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

final class SetApplicationLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('app_locale', 'en');
        if (auth()->check() && auth()->user()->preferred_locale) {
            $locale = auth()->user()->preferred_locale;
        }

        App::setLocale($locale);

        $dir = $locale === 'ar' ? 'rtl' : 'ltr';

        Inertia::share([
            'locale' => $locale,
            'dir' => $dir,
        ]);

        return $next($request);
    }
}
