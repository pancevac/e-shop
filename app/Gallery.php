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


    /******** ACCESSORS *********/

    public function getThumbnailAttribute()
    {
        return \Imagecache::get($this->attributes['file_path'], '120x90')->src;
    }

    public function getGalleryImageAttribute()
    {
        return \Imagecache::get($this->attributes['file_path'], 'product_image')->src;
    }

    public function getProductThumbnailAttribute()
    {
        return \Imagecache::get($this->attributes['file_path'], '60x60')->src;
    }


    /******** Relations *********/

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
