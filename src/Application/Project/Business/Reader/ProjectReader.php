<?php

namespace DevPM\Application\Project\Business\Reader;

use DevPM\Application\Project\Persistence\Repository\ProjectRepository;
use DevPM\Application\Project\Persistence\Shared\Transfer\ProjectTransfer;

class ProjectReader
{
    public function __construct(
      protected ProjectRepository $projectRepository,
    ) {
    }

    public function findById(string $id): ?ProjectTransfer
    {
        return $this->projectRepository->findById($id);
    }

    public function findAll(): array
    {
        return $this->projectRepository->findAll();
    }

    public function findAllByUserId(string $userId): array
    {
        return $this->projectRepository->findAllByUserId($userId);
    }
}
