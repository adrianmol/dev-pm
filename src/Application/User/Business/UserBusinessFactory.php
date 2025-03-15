<?php

namespace DevPM\Application\User\Business;

use DevPM\Application\User\Business\Reader\UserReader;
use DevPM\Application\User\Business\Writer\UserWriter;
use DevPM\Application\User\Persistence\Repository\UserRepository;

class UserBusinessFactory
{
    public function createUserWriter(): UserWriter
    {
        return new UserWriter(
            $this->createUserRepository(),
        );
    }

    public function createUserReader(): UserReader
    {
        return new UserReader(
            $this->createUserRepository(),
        );
    }

    protected function createUserRepository(): UserRepository
    {
        return new UserRepository;
    }
}
