<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates;

use Carbon\Carbon;

trait BooleanDates
{
    /**
     * Set the date of fields to the current date and time if a counterpart boolean field is
     * true-ish.
     *
     * Keys and values should be in the format: `'boolean_field' => 'internal_timestamp_field'`.
     *
     * @var array
     */
    protected $booleanDates = [];

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray() : array
    {
        $attributes = parent::attributesToArray();

        $attributes = $this->addBooleanDateAttributesToArray($attributes);

        return $attributes;
    }

    /**
     * Get an attribute from the model.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (! $key) {
            return null;
        }

        if ($this->hasBooleanDate($key)) {
            return ! is_null($this->attributes[$this->getBooleanDateField($key)]);
        }

        return parent::getAttribute($key);
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if ($this->hasBooleanDate($key)) {
            $this->setBooleanDate($key, $value);

            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * @return array
     */
    public function getBooleanDates() : array
    {
        return $this->booleanDates;
    }

    /**
     * @return array
     */
    public function getBooleanDateAttributes() : array
    {
        return array_intersect_key(
            $this->attributes,
            array_flip($this->getBooleanDates())
        );
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasBooleanDate(string $key) : bool
    {
        return array_key_exists($key, $this->getBooleanDates());
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setBooleanDate(string $key, $value) : void
    {
        // Only update the timestamp if the value is true and if it's not yet set
        // or if the value is false and we need to unset the field.
        if (! $value || ($value && $this->currentBooleanDateFieldValueIsNotYetSet($key))) {
            $this->attributes[$this->getBooleanDateField($key)] = $this->getNewBooleanDateValue($value);
        }
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function currentBooleanDateFieldValueIsNotYetSet(string $key) : bool
    {
        if (! array_key_exists($this->getBooleanDateField($key), $this->attributes)) {
            return true;
        }

        return is_null($this->attributes[$this->getBooleanDateField($key)]);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getBooleanDateField(string $key) : string
    {
        return $this->booleanDates[$key];
    }

    /**
     * @param $value
     *
     * @return string|null
     */
    public function getNewBooleanDateValue($value) : ?string
    {
        return $value ? $this->fromDateTime(Carbon::now()) : null;
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    protected function addBooleanDateAttributesToArray(array $attributes) : array
    {
        foreach ($this->getBooleanDates() as $booleanField => $date) {
            if (! array_key_exists($date, $attributes)) {
                continue;
            }

            $attributes[$booleanField] = ! is_null($date);
        }

        return $attributes;
    }
}
