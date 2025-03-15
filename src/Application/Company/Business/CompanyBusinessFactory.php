<?php

namespace DevPM\Application\Company\Business;

use DevPM\Application\Company\Business\Reader\CompanyReader;
use DevPM\Application\Company\Business\Writer\CompanyWriter;
use DevPM\Application\Company\Persistence\Repository\CompanyRepository;

class CompanyBusinessFactory
{
    public function createCompanyWriter(): CompanyWriter
    {
        return new CompanyWriter(
            $this->createCompanyRepository(),
        );
    }

    public function createCompanyReader(): CompanyReader
    {
        return new CompanyReader(
            $this->createCompanyRepository(),
        );
    }

    protected function createCompanyRepository(): CompanyRepository
    {
        return new CompanyRepository;
    }
}
