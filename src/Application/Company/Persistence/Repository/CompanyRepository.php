<?php

namespace DevPM\Application\Company\Persistence\Repository;

use DevPM\Application\Company\Persistence\Model\Company;
use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyEntityTransfer;
use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyTransfer;
use DevPM\Infrastructure\Constants\CommonConstants;
use DevPM\Infrastructure\Repository\BaseRepository;

class CompanyRepository extends BaseRepository
{
    public function create(
        CompanyTransfer $companyTransfer,
    ): ?CompanyTransfer {
        $companyEntityTransfer = (new CompanyEntityTransfer())
            ->fromArray($companyTransfer->toArray());

        $companyModel = static::getModel()
            ->fill($companyEntityTransfer->toArray());

        $created = $companyModel->save();

        if (!$created) {
            return null;
        }

        return $companyTransfer
            ->setId($companyModel->getAttribute(CommonConstants::ID));
    }

    public function update(
        string $id,
        CompanyTransfer $companyTransfer,
    ): ?CompanyTransfer {
        $companyModel = static::getModel()
            ->query()
            ->find($id);

        if ($companyModel === null) {
            return null;
        }

        $companyEntityTransfer = (new CompanyEntityTransfer())
            ->fromArray($companyTransfer->toArray());

        $companyModel
            ->fill($companyEntityTransfer->toArray())
            ->save();

        return $companyTransfer
            ->setId($companyModel->getAttribute(CommonConstants::ID));
    }

    public function deleteById(
        string $id,
    ): bool {
        return static::getModel()
            ->query()
            ->find($id)
            ?->delete() ?? false;
    }

    public function findById(string $id): ?CompanyTransfer
    {
        $companyModel = static::getModel()
            ->query()
            ->find($id);

        if ($companyModel === null) {
            return null;
        }

        return (new CompanyTransfer())
            ->fromArray($companyModel->toArray());
    }

    public function findAll(): array
    {
        $companyModelCollection = static::getModel()
            ->query()
            ->get();

        $companyTransferCollection = [];
        foreach ($companyModelCollection as $companyModel) {
            $companyTransferCollection[] = (new CompanyTransfer())
            ->fromArray($companyModel->toArray());
        }

        return $companyTransferCollection;
    }

    protected static function getModel(): Company
    {
        return new Company();
    }
}
