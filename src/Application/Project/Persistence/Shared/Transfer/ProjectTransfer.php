<?php

namespace DevPM\Application\Project\Persistence\Shared\Transfer;

use DevPM\Application\Company\Persistence\Shared\Transfer\CompanyTransfer;
use DevPM\Domain\DTOs\AbstractTransfer;

class ProjectTransfer extends AbstractTransfer
{
    public ?string $id;
    public ?string $name;
    public ?string $companyId;
    public ?array $userIds;
    public ?int $status;

    public ?CompanyTransfer $companyTransfer;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return  $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return  $this;
    }

    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    public function setCompanyId(?string $companyId): self
    {
        $this->companyId = $companyId;

        return  $this;
    }

    public function getUserIds(): ?array
    {
        return $this->userIds;
    }

    public function setUserIds(?array $userIds): self
    {
        $this->userIds = $userIds;

        return  $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCompanyTransfer(): ?CompanyTransfer
    {
        return $this->companyTransfer;
    }

    public function setCompanyTransfer(?CompanyTransfer $companyTransfer): self
    {
        $this->companyTransfer = $companyTransfer;

        return $this;
    }
}
