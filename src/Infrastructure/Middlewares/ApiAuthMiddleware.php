<?php

namespace DevPM\Infrastructure\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DevPM\Domain\Enums\LocaleEnum;

class ApiAuthMiddleware
{
    public const string HEADER_ACCEPT_LANGUAGE = 'Accept-Language';

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header(static::HEADER_ACCEPT_LANGUAGE) ?? null;
        app()->setLocale(LocaleEnum::ENGLISH->value);

        if (in_array($locale, LocaleEnum::getValues())) {
            app()->setLocale($request->header(static::HEADER_ACCEPT_LANGUAGE));
        }

        return $next($request);
    }
}
