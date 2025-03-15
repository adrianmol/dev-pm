<?php

namespace TrainerNow\Infrastructure\Middlewares;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DevPM\Infrastructure\Constants\ResponseConstants;

class MobileAuthMiddleware
{
    public const string MOBILE_AUTH_TOKEN = 'mobile-tr-token';

    public const string ENV_MOBILE_TOKEN = 'MOBILE_TOKEN';

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse|Response
    {
        if (
            $request->header(static::MOBILE_AUTH_TOKEN) !== env(static::ENV_MOBILE_TOKEN)
        ) {
            return \Illuminate\Support\Facades\Response::json(
                [
                    ResponseConstants::MESSAGE_KEY => 'Forbidden.',
                ],
                ResponseConstants::FORBIDDEN_HEADER_CODE
            );
        }

        return $next($request);
    }
}
