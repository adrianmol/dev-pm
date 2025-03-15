<?php

namespace DevPM\Domain\Enums;

use DevPM\Infrastructure\Traits\TraitEnum;

enum StatusEnum: int
{
    use TraitEnum;

    case INACTIVE = 0;
    case ACTIVE = 1;
    case PENDING = 2;
    case UNPAID = 3;
    case EXPIRED = 4;
}
