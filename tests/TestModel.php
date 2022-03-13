<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use SebastiaanLuca\BooleanDates\BooleanDateAttribute;

class TestModel extends Model
{
    /**
     * @var bool
     */
    protected static $unguarded = true;

    /**
     * The storage format of the model's date columns.
     *
     * Set this manually so creating the model with date attributes doesn't
     * have to check the database.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'accepted_terms_at' => 'immutable_datetime',
        'subscribed_to_newsletter_at' => 'datetime',
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'has_accepted_terms',
        'is_subscribed_to_newsletter',
    ];

    protected function hasAcceptedTerms(): Attribute
    {
        return BooleanDateAttribute::for('accepted_terms_at');
    }

    protected function isSubscribedToNewsletter(): Attribute
    {
        return BooleanDateAttribute::for('subscribed_to_newsletter_at');
    }
}
