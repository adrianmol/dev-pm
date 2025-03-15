<?php

namespace DevPM\Application\User\Business;

use DevPM\Application\User\Persistence\Model\User;
use DevPM\Application\User\Persistence\Shared\Transfer\AuthUserTransfer;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Infrastructure\Constants\CommonConstants;

class UserFacade
{
    protected static ?UserBusinessFactory $userBusinessFactory = null;

    public function __construct()
    {
        if (static::$userBusinessFactory === null) {
            static::$userBusinessFactory = new UserBusinessFactory();
        }
    }

    public function create(UserTransfer $userTransfer): ?UserTransfer
    {
        return static::$userBusinessFactory
            ->createUserWriter()
            ->create($userTransfer);
    }

    public function list(): array
    {
        return static::$userBusinessFactory
            ->createUserReader()
            ->list();
    }

    public function authenticate(string $email, string $password): ?AuthUserTransfer
    {
        return static::$userBusinessFactory
            ->createUserReader()
            ->authenticate($email, $password);
    }

    public function deleteAccessToken(): void
    {
        Auth()->guard(CommonConstants::SANCTUM)->user()?->currentAccessToken()?->delete();
    }

    public function getLoginUserData(): ?UserTransfer
    {
        /** @var User $user */
        $user = Auth()->guard(CommonConstants::SANCTUM)->user();

        return $user
            ? (new UserTransfer())
                ->fromArray($user->toArray())
                ->setRole($user->getRoleNames()?->first())
            : null;
    }
}
