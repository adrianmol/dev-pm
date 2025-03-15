<?php

namespace DevPM\Application\Company\Business\Reader;

use DevPM\Application\Company\Persistence\Repository\CompanyRepository;
use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyTransfer;

class CompanyReader
{
    public function __construct(
      protected CompanyRepository $companyRepository,
    ) {
    }

    public function findById(string $id): ?CompanyTransfer
    {
        return $this->companyRepository->findById($id);
    }

    public function findAll(): array
    {
        return $this->companyRepository->findAll();
    }
}
