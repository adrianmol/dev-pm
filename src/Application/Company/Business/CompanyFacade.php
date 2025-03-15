<?php

namespace DevPM\Application\Company\Business;

use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyTransfer;

class CompanyFacade
{
    protected static ?CompanyBusinessFactory $companyBusinessFactory = null;

    public function __construct()
    {
        if (static::$companyBusinessFactory === null) {
            static::$companyBusinessFactory = new CompanyBusinessFactory();
        }
    }

    public function create(CompanyTransfer $companyTransfer): ?CompanyTransfer
    {
        return static::$companyBusinessFactory
            ->createCompanyWriter()
            ->create($companyTransfer);
    }

    public function update(string $id, CompanyTransfer $companyTransfer): ?CompanyTransfer
    {
        return static::$companyBusinessFactory
            ->createCompanyWriter()
            ->update($id, $companyTransfer);
    }

    public function deleteById(string $id): bool
    {
        return static::$companyBusinessFactory
            ->createCompanyWriter()
            ->deleteById($id);
    }

    public function findById(string $id): ?CompanyTransfer
    {
        return static::$companyBusinessFactory
            ->createCompanyReader()
            ->findById($id);
    }

    public function findAll(): array
    {
        return static::$companyBusinessFactory
            ->createCompanyReader()
            ->findAll();
    }
}
