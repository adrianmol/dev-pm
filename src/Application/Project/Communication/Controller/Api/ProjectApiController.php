<?php

namespace DevPM\Application\Project\Communication\Controller\Api;

use DevPM\Application\Project\Business\ProjectFacade;
use DevPM\Application\Project\Communication\Controller\Request\ProjectCreateRequest;
use DevPM\Application\Project\Communication\Controller\Request\ProjectUpdateRequest;
use DevPM\Application\User\Business\UserFacade;
use DevPM\Domain\Enums\RoleEnum;
use DevPM\Infrastructure\Constants\ResponseConstants;
use DevPM\Infrastructure\Controllers\ApiBaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProjectApiController extends ApiBaseController
{
    public function __construct(
        protected UserFacade $userFacade,
        protected ProjectFacade $projectFacade,
    ) {
    }

    public function createAction(ProjectCreateRequest $request): JsonResponse
    {
        $userTransfer = $this->userFacade->getLoginUserData();
        if ($userTransfer?->getRole() !== RoleEnum::ADMIN->value) {
            return $this->responseForbidden();
        }

        $projectTransfer = $request->getTransferData();

        $this->projectFacade->create($projectTransfer);

        return response()->json(
            [
                ResponseConstants::PROJECT_KEY => $projectTransfer,
            ],
            ResponseConstants::CREATED_HEADER_CODE,
        );
    }

    public function updateAction(string $id, ProjectUpdateRequest $request): JsonResponse
    {
        $userTransfer = $this->userFacade->getLoginUserData();
        if ($userTransfer?->getRole() !== RoleEnum::ADMIN->value) {
            return $this->responseForbidden();
        }

        $projectTransfer = $request->getTransferData();

        $projectTransfer = $this->projectFacade->update(
            $id,
            $projectTransfer
        );

        return response()->json(
            [
                ResponseConstants::PROJECT_KEY => $projectTransfer,
            ],
        );
    }

    public function viewAction(string $id): JsonResponse
    {
        $projectTransfer = $this->projectFacade->findById($id);

        if ($projectTransfer === null) {
            return $this->responseNotFound($id);
        }

        return response()->json(
            [
                ResponseConstants::PROJECT_KEY => $projectTransfer,
            ]
        );
    }

    public function deleteAction(string $id): JsonResponse|Response
    {
        $userTransfer = $this->userFacade->getLoginUserData();
        if ($userTransfer?->getRole() !== RoleEnum::ADMIN->value) {
            return $this->responseForbidden();
        }

        $deleted = $this->projectFacade->deleteById($id);

        return response()->noContent();
    }

    public function listAction(): JsonResponse
    {
        $userTransfer = $this->userFacade->getLoginUserData();
        if ($userTransfer?->getRole() === RoleEnum::ADMIN->value) {
            $projectTransferCollection = $this->projectFacade->findAll();
        } else {
            $projectTransferCollection = $this->projectFacade->findAllByUserId($userTransfer->getId());
        }

        return response()->json(
            [
                ResponseConstants::PROJECT_COLLECTION_KEY => $projectTransferCollection,
            ]
        );
    }
}
