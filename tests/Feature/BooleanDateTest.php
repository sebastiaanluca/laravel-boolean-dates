<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests\Feature;

use Carbon\Carbon;
use SebastiaanLuca\BooleanDates\Tests\resources\TestModel;
use SebastiaanLuca\BooleanDates\Tests\TestCase;

class BooleanDateTest extends TestCase
{
    /**
     * @test
     */
    public function it leaves other date attributes untouched(): void
    {
        $model = new TestModel;

        $model->tested_at = Carbon::now('+5 days');

        $this->assertSame(
            Carbon::now('+5 days')->format('Y-m-d H:i:s'),
            $model->tested_at->format('Y-m-d H:i:s')
        );
    }

    /**
     * @test
     */
    public function it returns a date object from a true attribute(): void
    {
        $model = new TestModel;

        $model->allows_data_processing = true;

        $this->assertInstanceOf(
            Carbon::class,
            $model->accepted_processing_at
        );

        $this->assertEquals(
            Carbon::now()->format('Y-m-d H:i:s'),
            $model->accepted_processing_at->format('Y-m-d H:i:s')
        );
    }

    /**
     * @test
     */
    public function it returns null from a false attribute(): void
    {
        $model = new TestModel;

        $model->allows_data_processing = false;

        $this->assertNull($model->accepted_processing_at);
    }
}
