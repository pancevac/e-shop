<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount',
        'amount',
        'publish_from',
        'valid_until',
        'publish',
        'forever',
    ];

    // Relations

    /**
     * The orders that belong to coupon
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

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

    /**
     * Determine if coupon is valid and return it if yes
     *
     * @param $couponCode
     * @return mixed
     */
    public static function getValidCoupon($couponCode)
    {
        return self::published()
            ->where('amount', '>', 0)
            ->whereCode($couponCode)
            ->where([
                ['publish_from', '<', Carbon::now()],
                ['valid_until', '>', Carbon::now()],
            ])
            ->orWhere('forever', true)
            ->first();
    }


}
