<?php

namespace DevPM\Domain\Persistence\Shared\Sort;

use DevPM\Domain\DTOs\AbstractTransfer;

class SortTransfer extends AbstractTransfer
{
    public ?string $sortBy;

    public ?string $direction;

    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }

    public function setSortBy(?string $sortBy): self
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(?string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }
}
