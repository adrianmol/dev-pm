<?php

namespace DevPM\Application\User\Persistence\Shared\Transfer;

use DevPM\Domain\DTOs\AbstractTransfer;

class AuthUserTransfer extends AbstractTransfer
{
    public ?string $errorMessage;

    public ?UserTransfer $userTransfer;

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return  $this;
    }

    public function getUserTransfer(): ?UserTransfer
    {
        return $this->userTransfer;
    }

    public function setUserTransfer(?UserTransfer $userTransfer): self
    {
        $this->userTransfer = $userTransfer;

        return  $this;
    }
}
