<?php

namespace DevPM\Domain\DTOs;

use DateTime;
use DevPM\Infrastructure\Constants\CommonConstants;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

abstract class AbstractTransfer extends DataTransferObject
{
    protected static array $protectedKeys = [
        'exceptKeys',
        'onlyKeys',
    ];

    protected static array $propertyTypes = [
    ];

    public function fromArray(?array $data): static
    {
        if (is_null($data)) {
            return $this;
        }

        foreach ($data as $key => $value) {
            $convertKeyToSnakeCase = Str::camel($key);
            if (property_exists($this, $convertKeyToSnakeCase)) {
                if (isset(static::$propertyTypes[$key]) && ! is_null($value)) {
                    if (is_object($value)) {
                        $this->$convertKeyToSnakeCase = $value;

                        continue;
                    }
                    try {
                        $this->$convertKeyToSnakeCase = new static::$propertyTypes[$key]($value);

                        continue;
                    } catch (\Exception $e) {
                        continue;
                    }
                }
                try {
                    $this->$convertKeyToSnakeCase = $value;
                } catch (\Throwable $e) {
                }
            }
        }

        return $this;
    }

    public function propertiesToArray(bool $snakeCased = false, bool $nullableValues = true): array
    {
        if ($snakeCased) {
            return $this->parseToSnakeCase($nullableValues);
        }

        return $this->parseToCamelCase($nullableValues);
    }

    public function toArray(
        bool $nullableValues = true,
        bool $parseToSnakeCase = true,
    ): array {
        if ($parseToSnakeCase) {
            return $this->parseToSnakeCase($nullableValues);
        }

        if ($nullableValues) {
            return parent::toArray();
        }

        return collect($this->all())
            ?->filter(fn ($value) => ! is_null($value))
            ?->toArray() ?? [];
    }

    protected function parseToSnakeCase(bool $nullableValues = true): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            if (! in_array($key, static::$protectedKeys)) {
                if (! $nullableValues && is_null($value)) {
                    continue;
                }

                $array[Str::snake($key)] = $value;
            }
        }

        return $array;
    }

    protected function parseToCamelCase(bool $nullableValues = true): array
    {
        $array = [];

        foreach ($this as $key => $value) {
            if (! in_array($key, static::$protectedKeys)) {
                if (! $nullableValues && is_null($value)) {
                    continue;
                }
                if ($value instanceof DateTime) {
                    $array[Str::camel($key)] = $value->format(CommonConstants::DATETIME_FORMAT);

                    continue;
                }
                $array[Str::camel($key)] = $value;
            }
        }

        return $array;
    }
}
