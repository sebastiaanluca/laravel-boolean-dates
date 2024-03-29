<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BooleanDateAttribute extends Attribute
{
    public static function for(string $column): static
    {
        return parent::make(
            get: static fn (mixed $value, array $attributes): bool => static::getBooleanDate($attributes, $column),
            set: static fn (mixed $value, array $attributes): array => static::setBooleanDate($value, $attributes, $column),
        );
    }

    private static function getBooleanDate(array $attributes, string $column): bool
    {
        return array_key_exists($column, $attributes) && $attributes[$column] !== null;
    }

    private static function setBooleanDate(mixed $value, array $attributes, string $column): array
    {
        // Only update the field if it's never been set before or when it's being "disabled"
        if (! $value || ! array_key_exists($column, $attributes) || $attributes[$column] === null) {
            return [$column => ! $value ? null : CarbonImmutable::now()];
        }

        return [];
    }
}
