<?php

declare(strict_types=1);

namespace App\Support;

use JsonException;

final class PublicApiValue
{
    /**
     * @return array<string|int, mixed>
     */
    public static function arrayValue(mixed $value): array
    {
        $decoded = self::decode($value);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @return array<int, mixed>
     */
    public static function listValue(mixed $value): array
    {
        $decoded = self::arrayValue($value);

        if ($decoded === []) {
            return [];
        }

        return array_is_list($decoded) ? $decoded : [$decoded];
    }

    /**
     * @return array<string|int, mixed>
     */
    public static function firstArray(mixed $value): array
    {
        $decoded = self::arrayValue($value);

        if ($decoded === []) {
            return [];
        }

        if (! array_is_list($decoded)) {
            return $decoded;
        }

        foreach ($decoded as $item) {
            if (is_array($item)) {
                return $item;
            }
        }

        return [];
    }

    public static function stringValue(mixed $value): string
    {
        return is_scalar($value) ? trim((string) $value) : '';
    }

    /**
     * @return array<int, string>
     */
    public static function stringList(mixed $value): array
    {
        $decoded = self::decode($value);

        if (is_array($decoded)) {
            return array_values(array_filter(array_map(
                static fn (mixed $item): string => is_scalar($item) ? trim((string) $item) : '',
                $decoded,
            )));
        }

        $string = self::stringValue($decoded);

        if ($string === '') {
            return [];
        }

        return array_values(array_filter(array_map(
            static fn (string $item): string => trim($item),
            preg_split('/\s*,\s*/', $string) ?: [],
        )));
    }

    private static function decode(mixed $value): mixed
    {
        if (! is_string($value)) {
            return $value;
        }

        $trimmed = trim($value);

        if ($trimmed === '' || ! in_array($trimmed[0], ['{', '['], true)) {
            return $value;
        }

        try {
            return json_decode($trimmed, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return $value;
        }
    }
}
