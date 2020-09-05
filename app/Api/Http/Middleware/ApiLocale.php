<?php

namespace Api\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * Class ApiLocale
 * @package Api\Http\Middleware
 */
class ApiLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $default = config('app.locale');
        $locales = config('app.locales');

        $locale = $request->header('locale');

        if (empty($locale)) {
            $locale = $default;
        } elseif (!in_array($locale, $locales)) {
            throw new \Exception('Not supported locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
