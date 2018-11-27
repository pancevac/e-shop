<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount',
        'amount',
        'publish_at',
        'valid_until',
        'publish',
        'forever',
    ];

    /**
     * Scope published
     *
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->wherePublish(true);
    }


}
