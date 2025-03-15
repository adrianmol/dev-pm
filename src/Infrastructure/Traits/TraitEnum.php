<?php

namespace DevPM\Infrastructure\Traits;

trait TraitEnum
{
    public const string VALUE = 'value';

    public const string NAME = 'name';

    public static function getValues(): array
    {
        return array_column(self::cases(), self::VALUE);
    }

    public static function getNames(): array
    {
        return array_column(self::cases(), self::NAME);
    }

    public static function getKeysValues(): array
    {
        return array_combine(self::getValues(), self::getNames());
    }
}
