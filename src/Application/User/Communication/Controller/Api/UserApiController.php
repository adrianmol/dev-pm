<?php

namespace DevPM\Application\User\Communication\Controller\Api;

use DevPM\Application\User\Business\UserFacade;
use DevPM\Application\User\Communication\Controller\Request\UserLoginRequest;
use DevPM\Application\User\Communication\Controller\Request\UserRegisterRequest;
use DevPM\Application\User\Persistence\Shared\Transfer\Api\UserApiTransfer;
use DevPM\Infrastructure\Constants\ResponseConstants;
use DevPM\Infrastructure\Controllers\ApiBaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserApiController extends ApiBaseController
{
    public function __construct(
        protected UserFacade $userFacade,
    ) {
    }

    public function registerAction(UserRegisterRequest $request): JsonResponse
    {
        $userTransfer = $request->getTransferData();

        $userTransfer = $this->userFacade->create($userTransfer);

        if ($userTransfer === null) {
            return $this->responseBadRequest();
        }

        return response()->json(
            [
                ResponseConstants::USER_KEY => (new UserApiTransfer())
                    ->fromArray($userTransfer->toArray()),
            ],
            ResponseConstants::CREATED_HEADER_CODE,
        );
    }

    public function loginAction(UserLoginRequest $request): JsonResponse
    {
        $userTransfer = $request->getTransferData();

        $authUserTransfer = $this->userFacade->authenticate(
            $userTransfer->getEmail(),
            $userTransfer->getPassword(),
        );

        if ($authUserTransfer->getErrorMessage()) {
            return $this->responseBadRequest($authUserTransfer->getErrorMessage());
        }

        return response()->json(
            [
                ResponseConstants::USER_KEY => (new UserApiTransfer())
                    ->fromArray($authUserTransfer->getUserTransfer()->toArray()),
            ],
        );
    }

    public function logoutAction(): Response
    {
        $this->userFacade->deleteAccessToken();

        return response()->noContent();
    }

    public function listAction(): JsonResponse
    {
        return response()->json(
            [
                ResponseConstants::USER_COLLECTION_KEY => $this->userFacade->list(),
            ],
        );
    }
}
