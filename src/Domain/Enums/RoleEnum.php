<?php

namespace DevPM\Domain\Enums;

use DevPM\Infrastructure\Traits\TraitEnum;

enum RoleEnum: string
{
    use TraitEnum;

    case ADMIN = 'admin';
    case STAFF = 'staff';
}
