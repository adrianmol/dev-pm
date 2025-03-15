<?php

namespace DevPM\Infrastructure\Helpers;

class DevPMHelper
{
    public const string DOMAIN_TRAINER_NOW_PATH = '/src/Domain';

    public const string APPLICATION_TRAINER_NOW_PATH = '/src/Application';

    public static function getDomainPath(): string
    {
        return base_path().static::DOMAIN_TRAINER_NOW_PATH;
    }

    public static function getApplicationPath(): string
    {
        return base_path().static::APPLICATION_TRAINER_NOW_PATH;
    }
}
