<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon $expiresAt
 */
class Subscription extends Model
{
    protected $dates = [
        'expiresAt',
    ];
}
