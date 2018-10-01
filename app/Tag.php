<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'publish'
    ];

    /**
     * Set brand slug, if slug field have value, make slug of it, otherwise make slug of title.
     *
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        if ($value) {
            $this->attributes['slug'] = str_slug($value);
        }
        else {
            $this->attributes['slug'] = str_slug(request('title'));
        }
    }

    /**
     * Scope published
     *
     * @param $query
     */
    public function scopePublished($query)
    {
        $query->where('publish', 1);
    }

    /**
     * Product many-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
