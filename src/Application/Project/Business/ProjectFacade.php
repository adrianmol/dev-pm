<?php

namespace DevPM\Application\Project\Business;

use DevPM\Application\Project\Persistence\Shared\Transfer\ProjectTransfer;

class ProjectFacade
{
    protected static ?ProjectBusinessFactory $projectBusinessFactory = null;

    public function __construct()
    {
        if (static::$projectBusinessFactory === null) {
            static::$projectBusinessFactory = new ProjectBusinessFactory();
        }
    }

    public function create(ProjectTransfer $projectTransfer): ?ProjectTransfer
    {
        return static::$projectBusinessFactory
            ->createProjectWriter()
            ->create($projectTransfer);
    }

    public function update(
        $id,
        $projectTransfer,
    ): ?ProjectTransfer {
        return static::$projectBusinessFactory
            ->createProjectWriter()
            ->update($id, $projectTransfer);
    }

    public function deleteById(string $id): bool
    {
        return static::$projectBusinessFactory
            ->createProjectWriter()
            ->deleteById($id);
    }

    public function findById(string $id): ?ProjectTransfer
    {
        return static::$projectBusinessFactory
            ->createProjectReader()
            ->findById($id);
    }

    public function findAll(): array
    {
        return static::$projectBusinessFactory
            ->createProjectReader()
            ->findAll();
    }

    public function findAllByUserId(string $userId): array
    {
        return static::$projectBusinessFactory
            ->createProjectReader()
            ->findAllByUserId($userId);
    }
}
