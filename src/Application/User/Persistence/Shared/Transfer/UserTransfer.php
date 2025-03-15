<?php

namespace DevPM\Application\User\Persistence\Shared\Transfer;

use DevPM\Application\User\Persistence\Model\User;
use DevPM\Domain\DTOs\AbstractTransfer;

class UserTransfer extends AbstractTransfer
{
    public ?string $id;
    public ?string $name;
    public ?string $email;
    public ?string $password;
    public ?string $accessToken;
    public ?string $role;
    public ?User $userModel;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(?string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getUserModel(): ?User
    {
        return $this->userModel;
    }

    public function setUserModel(?User $userModel): self
    {
        $this->userModel = $userModel;

        return $this;
    }
}
