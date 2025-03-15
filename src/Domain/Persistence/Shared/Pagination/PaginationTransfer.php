<?php

namespace DevPM\Domain\Persistence\Shared\Pagination;

use DevPM\Domain\DTOs\AbstractTransfer;

class PaginationTransfer extends AbstractTransfer
{
    public ?int $offset;

    public ?int $limit;

    public ?int $page;

    public ?bool $hasMorePages;

    public ?int $totalItems;

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function setOffset(?int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getTotalItems(): ?int
    {
        return $this->totalItems;
    }

    public function setTotalItems(?int $totalItems): self
    {
        $this->totalItems = $totalItems;

        return $this;
    }

    public function getHasMorePages(): ?bool
    {
        return $this->hasMorePages;
    }

    public function setHasMorePages(?bool $hasMorePages): self
    {
        $this->hasMorePages = $hasMorePages;

        return $this;
    }
}
