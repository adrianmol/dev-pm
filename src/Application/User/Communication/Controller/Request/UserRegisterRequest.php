<?php

namespace DevPM\Application\User\Communication\Controller\Request;

use DevPM\Application\User\Persistence\Shared\Constant\UserApiConstant;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Domain\Requests\ApiRequest;

class UserRegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            UserApiConstant::NAME => ['required'],
            UserApiConstant::EMAIL => ['required','email', 'unique:users,email'],
            UserApiConstant::PASSWORD => ['required', 'min:8'],
            UserApiConstant::REPEAT_PASSWORD => ['required', 'min:8', 'same:password'],
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
            ->setName($this->getName())
            ->setEmail($this->getEmail())
            ->setPassword($this->getPasswordFromBody());
    }

    protected function getName(): string
    {
        return static::getMapUtils()
            ->safeString($this->input(
                UserApiConstant::NAME
            ));
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
