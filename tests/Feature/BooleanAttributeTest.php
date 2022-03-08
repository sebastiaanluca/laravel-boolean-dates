<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests\Feature;

use Carbon\Carbon;
use SebastiaanLuca\BooleanDates\Tests\resources\TestModel;
use SebastiaanLuca\BooleanDates\Tests\TestCase;

class BooleanAttributeTest extends TestCase
{
    /**
     * @test
     */
    public function it skips returning invalid fields(): void
    {
        $model = new TestModel;

        $this->assertNull($model->getAttribute(null));
        $this->assertNull($model->getAttribute(false));
        $this->assertNull($model->getAttribute(''));
        $this->assertNull($model->getAttribute('0'));
    }

    /**
     * @test
     */
    public function it leaves other attributes untouched(): void
    {
        $model = new TestModel;

        $model->something = 'something';

        $this->assertSame(
            'something',
            $model->something
        );
    }

    /**
     * @test
     */
    public function it sets the date from a true boolean(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms_and_conditions = true;

        $this->assertSame(
            Carbon::now()->format('Y-m-d H:i'),
            $model->accepted_terms_at->format('Y-m-d H:i')
        );
    }

    /**
     * @test
     */
    public function it sets the date from a non empty string(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms_and_conditions = 'yes';

        $this->assertSame(
            Carbon::now()->format('Y-m-d H:i'),
            $model->accepted_terms_at->format('Y-m-d H:i')
        );
    }

    /**
     * @test
     */
    public function it sets the date from a positive integer value(): void
    {
        $model = new TestModel;

        $model->has_agreed_to_something = 1;

        $this->assertSame(
            Carbon::now()->format('Y-m-d H:i'),
            $model->agreed_to_something_at->format('Y-m-d H:i')
        );
    }

    /**
     * @test
     */
    public function it sets the date from a positive integer string value(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms_and_conditions = '1';

        $this->assertSame(
            Carbon::now()->format('Y-m-d H:i'),
            $model->accepted_terms_at->format('Y-m-d H:i')
        );
    }

    /**
     * @test
     */
    public function it clears the date from a false boolean(): void
    {
        $model = new TestModel;

        $model->allows_data_processing = false;

        $this->assertNull($model->accepted_processing_at);
    }

    /**
     * @test
     */
    public function it clears the date from null(): void
    {
        $model = new TestModel;

        $model->has_agreed_to_something = null;

        $this->assertNull($model->agreed_to_something_at);
    }

    /**
     * @test
     */
    public function it clears the date from a false string value(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms_and_conditions = '0';

        $this->assertNull($model->accepted_terms_at);
    }

    /**
     * @test
     */
    public function it clears the date from an empty string value(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms_and_conditions = '0';

        $this->assertNull($model->accepted_terms_at);
    }
}
