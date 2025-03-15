<?php

namespace DevPM\Application\Project\Persistence\Shared\Transfer;

use DevPM\Domain\DTOs\AbstractTransfer;

class ProjectEntityTransfer extends AbstractTransfer
{
    public ?string $id;
    public ?string $name;
    public ?string $companyId;
    public ?int $status;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return  $this;
    }
}
