<?php

namespace DevPM\Application\Company\Communication\Controller\Request;

use DevPM\Application\Company\Persistence\Shared\Constant\CompanyApiConstant;
use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyTransfer;
use DevPM\Domain\Requests\ApiRequest;

class CompanyRegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            CompanyApiConstant::NAME => ['required'],
            CompanyApiConstant::DESCRIPTION => [],
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

    public function getTransferData(): CompanyTransfer
    {
        return (new CompanyTransfer)
            ->setName($this->getName())
            ->setDescription($this->getDescription());
    }

    protected function getName(): string
    {
        return static::getMapUtils()
            ->safeString($this->input(
                CompanyApiConstant::NAME
            ));
    }

    protected function getDescription(): ?string
    {
        return static::getMapUtils()
            ->safeString($this->input(
                CompanyApiConstant::DESCRIPTION
            ));
    }
}
