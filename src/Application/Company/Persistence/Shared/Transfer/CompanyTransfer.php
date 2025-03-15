<?php

namespace DevPM\Application\Company\Persistence\Shared\Transfer;

use DevPM\Domain\DTOs\AbstractTransfer;

class CompanyTransfer extends AbstractTransfer
{
    public ?string $id;
    public ?string $name;
    public ?string $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return  $this;
    }
}
