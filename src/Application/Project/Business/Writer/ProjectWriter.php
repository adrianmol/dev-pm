<?php

namespace DevPM\Application\Project\Business\Writer;

use DevPM\Application\Project\Persistence\Repository\ProjectRepository;
use DevPM\Application\Project\Persistence\Shared\Transfer\ProjectTransfer;

class ProjectWriter
{
    public function __construct(
      protected ProjectRepository $projectRepository,
    ) {
    }

    public function create(ProjectTransfer $projectTransfer): ?ProjectTransfer
    {
        return $this->projectRepository->create($projectTransfer);
    }

    public function update(
        $id,
        $projectTransfer,
    ): ?ProjectTransfer {
        return $this->projectRepository->update($id, $projectTransfer);
    }

    public function deleteById(string $id): bool
    {
        return $this->projectRepository->deleteById($id);
    }
}
