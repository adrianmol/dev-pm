<?php

namespace DevPM\Application\Project\Persistence\Repository;

use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyTransfer;
use DevPM\Application\Project\Persistence\Model\Project;
use DevPM\Application\Project\Persistence\Shared\Transfer\ProjectEntityTransfer;
use DevPM\Application\Project\Persistence\Shared\Transfer\ProjectTransfer;
use DevPM\Infrastructure\Constants\CommonConstants;
use DevPM\Infrastructure\Constants\TableConstants;
use DevPM\Infrastructure\Constants\Tables\TablesConstants;
use DevPM\Infrastructure\Repository\BaseRepository;

class ProjectRepository extends BaseRepository
{
    public function create(ProjectTransfer $projectTransfer): ?ProjectTransfer
    {
        $projectEntityTransfer = (new ProjectEntityTransfer())
            ->fromArray($projectTransfer->toArray());

        $projectModel = static::getModel()
            ->fill($projectEntityTransfer->toArray());

        $created = $projectModel->save();

        if (!$created) {
            return null;
        }

        if ($projectTransfer->getUserIds()) {
            $projectModel->users()->attach($projectTransfer->getUserIds());
        }

        return $projectTransfer
            ->setId($projectModel->getAttribute(CommonConstants::ID));
    }

    public function update(
        $id,
        $projectTransfer,
    ): ?ProjectTransfer {
        $projectModel = static::getModel()
            ->query()
            ->find($id);

        if ($projectModel === null) {
            return null;
        }

        $projectEntityTransfer = (new ProjectEntityTransfer())
            ->fromArray($projectTransfer->toArray());

        $projectModel = $projectModel
            ->fill($projectEntityTransfer->toArray(false));

        $updated = $projectModel->save();

        return $projectTransfer;
    }

    public function findById(string $id): ?ProjectTransfer
    {
        $projectModel = static::getModel()
            ->query()
            ->find($id);

        if ($projectModel === null) {
            return null;
        }

        return (new ProjectTransfer())
            ->fromArray($projectModel->toArray());
    }

    public function deleteById(string $id): bool
    {
        return static::getModel()
            ->query()
            ->find($id)
            ->delete() ?? false;
    }

    public function findAll(): array
    {
        $projectModelCollection = static::getModel()
            ->query()
            ->get();

        $projectTransferCollection = [];
        foreach ($projectModelCollection as $projectModel) {
            $projectTransferCollection[] = (new ProjectTransfer())
                ->fromArray($projectModel->toArray())
                ->setCompanyTransfer(
                    $projectModel->company
                        ? (new CompanyTransfer())->fromArray($projectModel->company->toArray())
                        : null
                );
        }

        return $projectTransferCollection;
    }

    public function findAllByUserId(string $userId): array
    {
        $projectModelCollection = static::getModel()
            ->query()
            ->whereHas(TablesConstants::USERS, function ($query) use ($userId) {
                $query->where(CommonConstants::USER_ID, $userId);
            })
            ->get();

        $projectTransferCollection = [];
        foreach ($projectModelCollection as $projectModel) {
            $projectTransferCollection[] = (new ProjectTransfer())
                ->fromArray($projectModel->toArray())
                ->setCompanyTransfer(
                    $projectModel->company
                        ? (new CompanyTransfer())->fromArray($projectModel->company->toArray())
                        : null
                );
        }

        return $projectTransferCollection;
    }

    protected static function getModel(): Project
    {
        return new Project();
    }
}
