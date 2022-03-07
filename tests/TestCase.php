<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use SebastiaanLuca\BooleanDates\BooleanDatesServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            BooleanDatesServiceProvider::class,
        ];
    }
}
