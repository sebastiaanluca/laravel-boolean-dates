<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests\resources;

use Illuminate\Database\Eloquent\Model;
use SebastiaanLuca\BooleanDates\HasBooleanDates;

class TestModel extends Model
{
    use HasBooleanDates;

    /**
     * Set the date of fields to the current date and time if a counterpart boolean field is
     * true-ish.
     *
     * Keys and values should be in the format: `'boolean_field' => 'internal_timestamp_field'`.
     *
     * @var array
     */
    protected $booleanDates = [
        'has_accepted_terms_and_conditions' => 'accepted_terms_at',
        'allows_data_processing' => 'accepted_processing_at',
        'has_agreed_to_something' => 'agreed_to_something_at',
    ];
}
