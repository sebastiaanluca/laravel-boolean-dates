<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests;

use Carbon\CarbonImmutable;
use Illuminate\Support\Carbon;

class BooleanAttributeTest extends TestCase
{
    /**
     * @test
     */
    public function it can handle initial values(): void
    {
        $model = new TestModel([
            'accepted_terms_at' => 1,
            'subscribed_to_newsletter_at' => Carbon::now(),
        ]);

        $this->assertInstanceOf(CarbonImmutable::class, $model->accepted_terms_at);
        $this->assertTrue($model->has_accepted_terms);

        $this->assertInstanceOf(Carbon::class, $model->subscribed_to_newsletter_at);
        $this->assertTrue($model->is_subscribed_to_newsletter);
    }

    /**
     * @test
     */
    public function it can handle empty initial values(): void
    {
        $model = new TestModel;

        $this->assertNull($model->accepted_terms_at);
        $this->assertFalse($model->has_accepted_terms);
    }

    /**
     * @test
     */
    public function it can enable a boolean attribute(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms = false;

        $this->assertNull($model->accepted_terms_at);
        $this->assertFalse($model->has_accepted_terms);

        $model->has_accepted_terms = true;

        $this->assertInstanceOf(CarbonImmutable::class, $model->accepted_terms_at);
        $this->assertTrue($model->has_accepted_terms);
    }

    /**
     * @test
     */
    public function it can disable a boolean attribute(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms = true;

        $this->assertInstanceOf(CarbonImmutable::class, $model->accepted_terms_at);
        $this->assertTrue($model->has_accepted_terms);

        $model->has_accepted_terms = false;

        $this->assertNull($model->accepted_terms_at);
        $this->assertFalse($model->has_accepted_terms);
    }

    /**
     * @test
     */
    public function it cannot enable a boolean attribute twice and change its date(): void
    {
        Carbon::setTestNow('2022-03-13 14:31:00');

        $model = new TestModel;

        $model->has_accepted_terms = true;

        $this->assertInstanceOf(CarbonImmutable::class, $model->accepted_terms_at);
        $this->assertSame('2022-03-13 14:31:00', $model->accepted_terms_at->toDateTimeString());
        $this->assertTrue($model->has_accepted_terms);

        $model->has_accepted_terms = true;

        $this->assertInstanceOf(CarbonImmutable::class, $model->accepted_terms_at);
        $this->assertSame('2022-03-13 14:31:00', $model->accepted_terms_at->toDateTimeString());
        $this->assertTrue($model->has_accepted_terms);
    }

    /**
     * @test
     */
    public function it can enable a boolean attribute twice if it was disabled(): void
    {
        Carbon::setTestNow('2022-03-13 14:00:00');

        $model = new TestModel;

        $model->is_subscribed_to_newsletter = true;

        $this->assertInstanceOf(Carbon::class, $model->subscribed_to_newsletter_at);
        $this->assertSame('2022-03-13 14:00:00', $model->subscribed_to_newsletter_at->toDateTimeString());
        $this->assertTrue($model->is_subscribed_to_newsletter);

        Carbon::setTestNow('2022-03-20 15:00:00');

        $model->is_subscribed_to_newsletter = false;

        $this->assertNull($model->subscribed_to_newsletter_at);
        $this->assertFalse($model->is_subscribed_to_newsletter);

        $model->is_subscribed_to_newsletter = true;

        $this->assertInstanceOf(Carbon::class, $model->subscribed_to_newsletter_at);
        $this->assertSame('2022-03-20 15:00:00', $model->subscribed_to_newsletter_at->toDateTimeString());
        $this->assertTrue($model->is_subscribed_to_newsletter);
    }

    /**
     * @test
     */
    public function it can enable a boolean attribute from a boolean(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms = true;

        $this->assertInstanceOf(CarbonImmutable::class, $model->accepted_terms_at);

        $this->assertSame(
            Carbon::now()->format('Y-m-d H:i'),
            $model->accepted_terms_at->format('Y-m-d H:i')
        );
    }

    /**
     * @test
     */
    public function it can enable a boolean attribute from a string(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms = 'yes';

        $this->assertSame(
            Carbon::now()->format('Y-m-d H:i'),
            $model->accepted_terms_at->format('Y-m-d H:i')
        );
    }

    /**
     * @test
     */
    public function it can enable a boolean attribute from an integer string(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms = '1';

        $this->assertSame(
            Carbon::now()->format('Y-m-d H:i'),
            $model->accepted_terms_at->format('Y-m-d H:i')
        );
    }

    /**
     * @test
     */
    public function it can enable a boolean attribute from an integer(): void
    {
        $model = new TestModel;

        $model->is_subscribed_to_newsletter = 1;

        $this->assertSame(
            Carbon::now()->format('Y-m-d H:i'),
            $model->subscribed_to_newsletter_at->format('Y-m-d H:i')
        );
    }

    /**
     * @test
     */
    public function it can disable a boolean attribute from a boolean(): void
    {
        $model = new TestModel;

        $model->allows_data_processing = false;

        $this->assertNull($model->accepted_processing_at);
    }

    /**
     * @test
     */
    public function it can disable a boolean attribute from null(): void
    {
        $model = new TestModel;

        $model->has_agreed_to_something = null;

        $this->assertNull($model->agreed_to_something_at);
    }

    /**
     * @test
     */
    public function it can disable a boolean attribute from an integer string(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms = '0';

        $this->assertNull($model->accepted_terms_at);
    }

    /**
     * @test
     */
    public function it can disable a boolean attribute from an integer(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms = 0;

        $this->assertNull($model->accepted_terms_at);
    }

    /**
     * @test
     */
    public function it can disable a boolean attribute from an empty string(): void
    {
        $model = new TestModel;

        $model->has_accepted_terms = '';

        $this->assertNull($model->accepted_terms_at);
    }

    /**
     * @test
     */
    public function it returns all attributes(): void
    {
        Carbon::setTestNow('2018-01-01 10:42:06');

        $model = new TestModel;

        $model->something = 'something';

        $model->has_accepted_terms = 0;
        $model->is_subscribed_to_newsletter = 1;

        $expected = [
            'something' => 'something',

            'accepted_terms_at' => null,
            'subscribed_to_newsletter_at' => '2018-01-01T10:42:06.000000Z',

            'has_accepted_terms' => false,
            'is_subscribed_to_newsletter' => true,
        ];

        $this->assertSame(
            $expected,
            $model->toArray(),
        );
    }
}
