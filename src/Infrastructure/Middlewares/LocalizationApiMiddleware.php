<?php

namespace DevPM\Infrastructure\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocalizationApiMiddleware
{
    public const string HEADER_ACCEPT_LANGUAGE = 'Accept-Language';

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        App::setLocale(
            is_array($request->header(static::HEADER_ACCEPT_LANGUAGE)) ||
            is_null($request->header(static::HEADER_ACCEPT_LANGUAGE))
                ? App::currentLocale()
                : $request->header(static::HEADER_ACCEPT_LANGUAGE)
        );

        return $next($request);
    }
}
