<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates;

use Illuminate\Support\Carbon;

trait HasBooleanDates
{
    public function initializeHasBooleanDates(): void
    {
        $this->dates = array_unique(
            array_merge(
                $this->dates,
                array_values($this->getBooleanDates())
            )
        );
    }

    public function attributesToArray(): array
    {
        $attributes = parent::attributesToArray();

        return $this->addBooleanDateAttributesToArray($attributes);
    }

    public function getAttribute($key)
    {
        if (! $key) {
            return null;
        }

        if ($this->hasBooleanDate($key)) {
            return $this->getBooleanDate($key);
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if ($this->hasBooleanDate($key)) {
            $this->setBooleanDate($key, $value);

            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    public function getBooleanDates(): array
    {
        return $this->booleanDates ?? [];
    }

    protected function getBooleanDateAttributes(): array
    {
        return array_intersect_key(
            $this->getAttributes(),
            array_flip($this->getBooleanDates())
        );
    }

    protected function getBooleanDate(string $key): bool
    {
        return parent::getAttribute($this->getBooleanDateField($key)) !== null;
    }

    protected function setBooleanDate(string $key, mixed $value): void
    {
        // Only update the timestamp if the value is true and if it's not yet set
        // or if the value is false and we need to unset the field.
        if (! $value || ($value && $this->currentBooleanDateFieldValueIsNotYetSet($key))) {
            // Set the value directly on the attributes array, don't use
            // setAttribute, and don't receive $200. (\) (°,,,°) (/)
            // This allows us to format and set the datetime ourselves,
            // and makes using the $dates field optional.
            $this->attributes[$this->getBooleanDateField($key)] = $this->getNewBooleanDateValue($value);
        }
    }

    protected function hasBooleanDate(string $key): bool
    {
        return array_key_exists($key, $this->getBooleanDates());
    }

    protected function currentBooleanDateFieldValueIsNotYetSet(string $key): bool
    {
        if (! array_key_exists($this->getBooleanDateField($key), $this->getAttributes())) {
            return true;
        }

        return parent::getAttribute($this->getBooleanDateField($key)) === null;
    }

    protected function getBooleanDateField(string $key): string
    {
        return $this->booleanDates[$key];
    }

    protected function getNewBooleanDateValue(mixed $value): ?string
    {
        return $value ? $this->fromDateTime(Carbon::now()) : null;
    }

    protected function addBooleanDateAttributesToArray(array $attributes): array
    {
        foreach ($this->getBooleanDates() as $booleanField => $date) {
            if (! array_key_exists($date, $attributes)) {
                continue;
            }

            $attributes[$booleanField] = $this->getBooleanDate($booleanField);
        }

        return $attributes;
    }
}
