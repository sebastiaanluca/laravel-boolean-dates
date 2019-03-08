<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests\Feature;

use Carbon\Carbon;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use SebastiaanLuca\BooleanDates\Tests\resources\TestModel;
use SebastiaanLuca\BooleanDates\Tests\TestCase;

class BooleanArrayTest extends TestCase
{
    use ArraySubsetAsserts;

    /**
     * @test
     */
    public function it returns all boolean dates() : void
    {
        $model = new TestModel;

        $expected = [
            'has_accepted_terms_and_conditions' => 'accepted_terms_at',
            'allows_data_processing' => 'accepted_processing_at',
            'has_agreed_to_something' => 'agreed_to_something_at',
        ];

        $this->assertSame(
            $expected,
            $model->getBooleanDates()
        );
    }

    /**
     * @test
     */
    public function it returns all attributes() : void
    {
        Carbon::setTestNow('2018-01-01 10:42:06');

        $model = new TestModel;

        $model->something = 'something';
        $model->tested_at = Carbon::now();

        $model->has_accepted_terms_and_conditions = false;
        $model->allows_data_processing = true;
        $model->has_agreed_to_something = '0';

        $expected = [
            'something' => 'something',
            'tested_at' => '2018-01-01 10:42:06',

            'has_accepted_terms_and_conditions' => false,
            'allows_data_processing' => true,
            'has_agreed_to_something' => false,

            'accepted_terms_at' => null,
            'accepted_processing_at' => '2018-01-01 10:42:06',
            'agreed_to_something_at' => null,
        ];

        ArraySubsetAsserts::assertArraySubset(
            $expected,
            $model->toArray()
        );
    }
}
