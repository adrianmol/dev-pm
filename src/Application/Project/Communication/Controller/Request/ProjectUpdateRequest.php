<?php

namespace DevPM\Application\Project\Communication\Controller\Request;

use DevPM\Application\Project\Persistence\Shared\Constant\ProjectApiConstant;
use DevPM\Application\Project\Persistence\Shared\Transfer\ProjectTransfer;
use DevPM\Domain\Requests\ApiRequest;
use DevPM\Infrastructure\Constants\CommonApiConstants;

class ProjectUpdateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            ProjectApiConstant::NAME => [],
            CommonApiConstants::COMPANY_ID => [],
            ProjectApiConstant::USER_IDS => ['array'],
        ];
    }

    public function attributes(): array
    {
        return [
        ];
    }

    public function messages(): array
    {
        return [
            //'phone' => ['code' => '1','test' => 'test'],
        ];
    }

    public function getTransferData(): ProjectTransfer
    {
        return (new ProjectTransfer)
            ->setName($this->getName())
            ->setCompanyId($this->getCompanyId())
            ->setUserIds($this->getUserIds());
    }

    protected function getName(): ?string
    {
        return static::getMapUtils()
            ->safeString($this->input(
                ProjectApiConstant::NAME
            ));
    }

    protected function getCompanyId(): ?string
    {
        return static::getMapUtils()
            ->safeString($this->input(
                CommonApiConstants::COMPANY_ID
            ));
    }

    protected function getUserIds(): ?array
    {
        return static::getMapUtils()
            ->safeArray($this->input(
                ProjectApiConstant::USER_IDS
            ));
    }
}
