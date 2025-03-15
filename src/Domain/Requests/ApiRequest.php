<?php

namespace DevPM\Domain\Requests;

use DevPM\Domain\DTOs\AbstractTransfer;
use DevPM\Infrastructure\Constants\ApiConstants;
use DevPM\Infrastructure\Constants\CommonConstants;
use DevPM\Infrastructure\Constants\SortConstants;
use DevPM\Infrastructure\Utils\MapUtils;
use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;
use DevPM\Domain\Persistence\Shared\Pagination\PaginationTransfer;
use DevPM\Infrastructure\Constants\PaginationConstants;
use DevPM\Domain\Persistence\Shared\Sort\SortTransfer;

abstract class ApiRequest extends FormRequest
{
    abstract public function getTransferData(): AbstractTransfer;

    public function getPagination(): PaginationTransfer
    {
        return (new PaginationTransfer)
            ->setLimit($this->query(PaginationConstants::LIMIT_KEY) ?? ApiConstants::DEFAULT_LIMIT)
            ->setPage($this->query(PaginationConstants::PAGE_KEY) ?? ApiConstants::DEFAULT_PAGE);
    }

    public function getSort(): SortTransfer
    {
        if ($this->query(SortConstants::SORT_KEY)) {
            $params = explode('_', $this->query(SortConstants::SORT_KEY));
            $sort = $params[0];
            $direction = $params[1];
        }

        return (new SortTransfer)
            ->setSortBy($sort ?? CommonConstants::ID)
            ->setDirection($direction ?? ApiConstants::DESC_DIRECTION);
    }

    protected static function getMapUtils(): MapUtils
    {
        return Container::getInstance()
            ->get(MapUtils::class);
    }
}
