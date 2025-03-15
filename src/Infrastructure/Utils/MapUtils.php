<?php

declare(strict_types=1);

namespace DevPM\Infrastructure\Utils;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Enum;
use ReflectionClass;
use RuntimeException;
use Throwable;

class MapUtils
{
    public function safeInt(int|string|null $value): ?int
    {
        return isset($value) ? (int) $value : null;
    }

    public function safeArray(?array $value): ?array
    {
        if (isset($value)) {
            return $value;
        }

        return null;
    }

    protected function safeIntId(int|string|null $value): ?int
    {
        return isset($value) && (is_int($value) || ctype_digit($value)) && $value > 0 ? (int) $value : null;
    }

    public function safeString(?string $value): ?string
    {
        return isset($value) ? trim($value) : null;
    }

    protected function safeStringJsonArray(?string $value): array
    {
        try {
            $result = $value
                ? json_decode(stripslashes($value), true, 512, JSON_THROW_ON_ERROR | JSON_PARTIAL_OUTPUT_ON_ERROR)
                : false;
        } catch (Exception $e) {
            $result = false;
        }

        return $result ?: [];
    }

    public function safeStringToTime(?string $value): ?int
    {
        return isset($value) ? (int) strtotime($value) : null;
    }

    private function safeToDateTime(?string $value, ?DateTimeZone $timezone): ?DateTime
    {
        try {
            return new DateTime($value, $timezone);
        } catch (Throwable $throwable) {
            Log::warning($throwable->getMessage());

            return null;
        }
    }

    private function safeToCarbon(?string $value, ?DateTimeZone $timezone): ?Carbon
    {
        try {
            return new Carbon($value, $timezone);
        } catch (Throwable $throwable) {
            Log::warning($throwable->getMessage());

            return null;
        }
    }

    public function safeStringToDateTime(?string $value, ?DateTimeZone $timezone = null): ?DateTime
    {
        return $value
            ? $this->safeToDateTime($value, $timezone)
            : null;
    }

    public function safeStringToCarbonDateTime(?string $value, ?DateTimeZone $timezone = null): ?Carbon
    {
        return $value
            ? $this->safeToCarbon($value, $timezone)
            : null;
    }

    protected function safeIntToDateTime(?string $value, ?DateTimeZone $timezone = null): ?DateTime
    {
        return $value > 1
            ? $this->safeToDateTime($value, $timezone)
            : null;
    }

    public function safeDateTimeToDateString(?DateTime $dateTime): ?string
    {
        return $dateTime?->format('Y-m-d');
    }

    public function safeFloat(float|string|null $value): ?float
    {
        return isset($value) ? (float) $value : null;
    }

    public function safeBool(bool|string|int|null $value): ?bool
    {
        if (isset($value)) {
            if (is_string($value)) {
                return $value === '1' || $value === 'true';
            }

            if (is_bool($value)) {
                return $value;
            }

            if (is_int($value)) {
                return (bool) $value;
            }
        }

        return null;
    }

    /**
     * @return string[]|null
     */
    public function safeStringArray(mixed $value): ?array
    {
        if (isset($value)) {
            if (is_array($value)) {
                return collect($value)
                    ->map(fn ($item) => (string) $item)
                    ->toArray();
            }

            return [(string) $value];
        }

        return null;
    }

    /**
     * @return int[]|null
     */
    public function safeIntArray(mixed $value): ?array
    {
        if (isset($value)) {
            if (is_array($value)) {
                return collect($value)
                    ->map(fn ($item) => (int) $item)
                    ->toArray();
            }

            return [(int) $value];
        }

        return null;
    }

    protected function safeDateTime(?string $value): ?DateTime
    {
        try {
            return $value
                ? new DateTime($value)
                : null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function safeUnixTimestampToDateTime(?int $value): ?DateTime
    {
        return ! is_null($value)
            ? new DateTime("@$value")
            : null;
    }

    public function safeIntToBool(mixed $value): ?bool
    {
        return isset($value) ? filter_var($value, FILTER_VALIDATE_BOOL) : null;
    }

    /**
     * @template T
     *
     * @param  class-string<T>  $enumClass
     * @return T|null
     */
    public function safeValueToEnum(mixed $value, string $enumClass)
    {
        if (! (new ReflectionClass($enumClass))->isEnum()) {
            throw new RuntimeException("The class: '$enumClass' isn't an instance of ".Enum::class);
        }

        if (! isset($value)) {
            return null;
        }

        return $enumClass::tryFrom($value);
    }
}
