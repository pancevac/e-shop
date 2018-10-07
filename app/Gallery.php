<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    /**
     * The attributes that are mass assignable;
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'file_name', 'file_path'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['thumbnail'];

    /**
     * Get the flag label for cached gallery image.
     *
     * @return mixed
     */
    public function getThumbnailAttribute()
    {
        return \Imagecache::get($this->attributes['file_path'], '120x90')->src;
    }

    /**
     * Product one-to-many relationship. Each gallery image belongs to one product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
