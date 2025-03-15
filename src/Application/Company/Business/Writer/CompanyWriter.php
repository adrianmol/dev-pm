<?php

namespace DevPM\Application\Company\Business\Writer;

use DevPM\Application\Company\Persistence\Repository\CompanyRepository;
use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyTransfer;

class CompanyWriter
{
    public function __construct(
        protected CompanyRepository $companyRepository,
    ){
    }

    public function create(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        return $this->companyRepository->create($companyTransfer);
    }

    public function update(string $id, CompanyTransfer $companyTransfer): CompanyTransfer
    {
        return $this->companyRepository->update($id, $companyTransfer);
    }

    public function deleteById(string $id): bool
    {
        return $this->companyRepository->deleteById($id);
    }
}
