<?php

namespace DevPM\Infrastructure\Controllers;

use DevPM\Infrastructure\Constants\Api\ErrorMessageConstant;
use DevPM\Infrastructure\Constants\ResponseConstants;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
abstract class ApiBaseController extends BaseController
{
    protected function responseNotFound(string $entityId): JsonResponse
    {
        return response()->json(
            [
                ResponseConstants::CODE_KEY => 404,
                ResponseConstants::MESSAGE_KEY => sprintf('Entity id (%s) not found', $entityId),
            ],
            ResponseConstants::NOT_FOUND_HEADER_CODE,
        );
    }

    protected function responseBadRequest(?string $message = 'Bad Request'): JsonResponse
    {
        return response()->json(
            [
                ResponseConstants::CODE_KEY => 400,
                ResponseConstants::MESSAGE_KEY => $message,
            ],
            ResponseConstants::BAD_REQUEST_HEADER_CODE,
        );
    }

    protected function responseForbidden(): JsonResponse
    {
        return response()->json(
            [
                ResponseConstants::CODE_KEY => 403,
                ResponseConstants::MESSAGE_KEY => ErrorMessageConstant::NO_ACCESS,
            ],
            ResponseConstants::FORBIDDEN_HEADER_CODE,
        );
    }
}
