<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests;

use ArrayAccess;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\Constraint\ArraySubset;
use PHPUnit\Util\InvalidArgumentHelper;

class Assert extends PHPUnit
{
    /**
     * Asserts that an array has a specified subset.
     *
     * This method was taken over from PHPUnit where it was deprecated. See link for more info.
     *
     * @param array|\ArrayAccess $subset
     * @param array|\ArrayAccess $array
     * @param bool $checkForObjectIdentity
     * @param string $message
     *
     * @return void
     *
     * @throws \Exception
     *
     * @link https://github.com/sebastianbergmann/phpunit/issues/3494
     */
    public static function assertArraySubset($subset, $array, bool $checkForObjectIdentity = false, string $message = '') : void
    {
        if (! (is_array($subset) || $subset instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(1, 'array or ArrayAccess');
        }

        if (! (is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(2, 'array or ArrayAccess');
        }

        $constraint = new ArraySubset($subset, $checkForObjectIdentity);

        static::assertThat($array, $constraint, $message);
    }
}
