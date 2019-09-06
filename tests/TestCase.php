<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use SebastiaanLuca\BooleanDates\BooleanDatesServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app) : array
    {
        return [
            BooleanDatesServiceProvider::class,
        ];
    }
}
