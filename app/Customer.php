<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'address1',
        'address2',
        'city',
        'country',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
