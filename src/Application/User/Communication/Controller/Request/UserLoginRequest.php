<?php

namespace DevPM\Application\User\Communication\Controller\Request;

use DevPM\Application\User\Persistence\Shared\Constant\UserApiConstant;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Domain\Requests\ApiRequest;

class UserLoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            UserApiConstant::EMAIL => ['required','email'],
            UserApiConstant::PASSWORD => ['required', 'min:8'],
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

    public function getTransferData(): UserTransfer
    {
        return (new UserTransfer)
            ->setEmail($this->getEmail())
            ->setPassword($this->getPasswordFromBody());
    }

    protected function getEmail(): string
    {
        return static::getMapUtils()
            ->safeString($this->input(
                UserApiConstant::EMAIL
            ));
    }

    protected function getPasswordFromBody(): string
    {
        return static::getMapUtils()
            ->safeString($this->input(
                UserApiConstant::PASSWORD
            ));
    }
}
