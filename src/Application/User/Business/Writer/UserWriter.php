<?php

namespace DevPM\Application\User\Business\Writer;

use DevPM\Application\User\Persistence\Repository\UserRepository;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Domain\Enums\RoleEnum;

class UserWriter
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function create(UserTransfer $userTransfer): ?UserTransfer
    {
        $this->userRepository->create($userTransfer, true);

        if($userTransfer->getRole() === null) {
            $userTransfer->setRole(RoleEnum::STAFF->value);
        }
        $this->userRepository->assignRole(
            $userTransfer->getId(),
            $userTransfer->getRole()
        );

        $userTransfer
            ->setPassword(null);

        return $userTransfer;
    }
}
