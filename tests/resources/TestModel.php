<?php

declare(strict_types=1);

namespace SebastiaanLuca\BooleanDates\Tests\resources;

use Illuminate\Database\Eloquent\Model;
use SebastiaanLuca\BooleanDates\BooleanDates;

class TestModel extends Model
{
    use BooleanDates;

    /**
     * @var array
     */
    protected $booleanDates = [
        'has_accepted_terms_and_conditions' => 'accepted_terms_at',
        'allows_data_processing' => 'accepted_processing_at',
        'has_agreed_to_something' => 'agreed_to_something_at',
    ];
}
