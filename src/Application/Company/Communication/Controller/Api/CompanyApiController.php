<?php

namespace DevPM\Application\Company\Communication\Controller\Api;

use DevPM\Application\Company\Business\CompanyFacade;
use DevPM\Application\Company\Communication\Controller\Request\CompanyRegisterRequest;
use DevPM\Application\Company\Communication\Controller\Request\CompanyUpdateRequest;
use DevPM\Application\User\Business\UserFacade;
use DevPM\Domain\Enums\RoleEnum;
use DevPM\Infrastructure\Constants\ResponseConstants;
use DevPM\Infrastructure\Controllers\ApiBaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyApiController extends ApiBaseController
{
    public function __construct(
        protected UserFacade $userFacade,
        protected CompanyFacade $companyFacade,
    ) {
    }

    public function createAction(CompanyRegisterRequest $request): JsonResponse
    {
        $userTransfer = $this->userFacade->getLoginUserData();
        if ($userTransfer?->getRole() !== RoleEnum::ADMIN->value) {
            return $this->responseForbidden();
        }

        $companyTransfer = $request->getTransferData();

        $companyTransfer = $this->companyFacade->create($companyTransfer);

        return response()->json(
            [
                ResponseConstants::COMPANY_KEY => $companyTransfer,
            ],
            ResponseConstants::CREATED_HEADER_CODE,
        );
    }

    public function updateAction(string $companyId, CompanyUpdateRequest $request): JsonResponse
    {
        $userTransfer = $this->userFacade->getLoginUserData();
        if ($userTransfer?->getRole() !== RoleEnum::ADMIN->value) {
            return $this->responseForbidden();
        }

        $companyTransfer = $request->getTransferData();

        $companyTransfer = $this->companyFacade->update(
            $companyId,
            $companyTransfer
        );

        return response()->json(
            [
                ResponseConstants::COMPANY_KEY => $companyTransfer,
            ],
        );
    }

    public function deleteAction(string $companyId): JsonResponse|Response
    {
        $userTransfer = $this->userFacade->getLoginUserData();
        if ($userTransfer?->getRole() !== RoleEnum::ADMIN->value) {
            return $this->responseForbidden();
        }

        $deleted = $this->companyFacade->deleteById($companyId);

        return response()->noContent();
    }

    public function viewAction(string $id): JsonResponse
    {
        $companyTransfer = $this->companyFacade->findById($id);

        if ($companyTransfer === null) {
            return $this->responseNotFound($id);
        }

        return response()->json(
            [
                ResponseConstants::COMPANY_KEY => $companyTransfer,
            ]
        );
    }

    public function listAction(): JsonResponse
    {
        $companyTransferCollection = $this->companyFacade->findAll();

        return response()->json(
            [
                ResponseConstants::COMPANY_COLLECTION_KEY => $companyTransferCollection,
            ]
        );
    }
}
