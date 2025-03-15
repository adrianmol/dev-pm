<?php

namespace DevPM\Application\User\Business\Reader;

use DevPM\Application\User\Persistence\Repository\UserRepository;
use DevPM\Application\User\Persistence\Shared\Transfer\AuthUserTransfer;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Infrastructure\Constants\Api\ErrorMessageConstant;
use Illuminate\Support\Facades\Hash;

class UserReader
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function authenticate(string $email, string $password): ?AuthUserTransfer
    {
        $authUserTransfer = new AuthUserTransfer();
        $userTransfer = $this->findByEmail($email, true);

        if ($userTransfer === null) {
            return $authUserTransfer
                ->setErrorMessage(ErrorMessageConstant::USER_NOT_FOUND);
        }

        if (!Hash::check($password, $userTransfer->getPassword())) {
            return $authUserTransfer
                ->setErrorMessage(ErrorMessageConstant::INVALID_CREDENTIALS);
        }

        $userTransfer
            ->setPassword(null);

        return $authUserTransfer
            ->setUserTransfer($userTransfer);
    }

    public function list(): array
    {
        return $this->userRepository->list();
    }

    protected function findByEmail(string $email, ?bool $generateToken = false): ?UserTransfer
    {
        return $this->userRepository->findByEmail($email, $generateToken);
    }
}
