<?php

namespace DevPM\Application\User\Persistence\Repository;

use DevPM\Application\User\Persistence\Model\User;
use DevPM\Application\User\Persistence\Shared\Constant\UserConstant;
use DevPM\Application\User\Persistence\Shared\Transfer\UserEntityTransfer;
use DevPM\Application\User\Persistence\Shared\Transfer\UserTransfer;
use DevPM\Infrastructure\Constants\CommonConstants;
use DevPM\Infrastructure\Repository\BaseRepository;

class UserRepository extends BaseRepository
{
    public function create(
        UserTransfer $userTransfer,
        ?bool $generateToken = false,
    ): ?UserTransfer {
        $userEntityTransfer = (new UserEntityTransfer)
            ->fromArray($userTransfer->toArray());

        $userModel = self::getModel()
            ->fill($userEntityTransfer->toArray());

        $created = $userModel
            ->save();

        if ($created === false) {
            return null;
        }

        return $userTransfer
            ->setId($userModel->getAttribute(CommonConstants::ID))
            ->setAccessToken(
                $generateToken
                    ? $userModel->createToken(CommonConstants::API_KEY_TOKEN)->plainTextToken
                    : null
            );
    }

    public function findByEmail(
        string $email,
        ?bool $generateToken = false,
    ): ?UserTransfer {
        $userModel = self::getModel()
            ->query()
            ->where([UserConstant::EMAIL => $email])
            ->get()
            ->first();

        /** @var ?User $userModel */
        if ($userModel === null) {
            return null;
        }

        return (new UserTransfer())
            ->fromArray($userModel->toArray())
            ->setPassword($userModel->makeVisible([UserConstant::PASSWORD])->getAttribute(UserConstant::PASSWORD))
            ->setRole($userModel->getRoleNames()->first())
            ->setAccessToken(
                $generateToken
                    ? $userModel->createToken(CommonConstants::API_KEY_TOKEN)->plainTextToken
                    : null
            );
    }

    public function assignRole(string $id, string $role): bool
    {
        return static::getModel()
            ->query()
            ->find($id)
            ?->assignRole($role);
    }

    public function list(): array
    {
        $userModelCollection = static::getModel()
            ->query()
            ->get();

        $userTransferCollection = [];
        foreach ($userModelCollection as $userModel) {
            $userTransferCollection[] = (new UserTransfer())
                ->fromArray($userModel->toArray());
        }

        return $userTransferCollection;
    }

    protected static function getModel(): User
    {
        return new User();
    }
}
