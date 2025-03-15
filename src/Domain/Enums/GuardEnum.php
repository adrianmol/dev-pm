<?php

namespace DevPM\Domain\Enums;

use DevPM\Infrastructure\Traits\TraitEnum;

enum GuardEnum: string
{
    use TraitEnum;

    case API = 'api';
    case WEB = 'web';
}
