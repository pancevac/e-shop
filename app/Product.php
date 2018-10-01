<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'brand_id', 'title', 'slug', 'code', 'short', 'description', 'image', 'price', 'price_outlet', 'views', 'stock', 'featured', 'publish', 'publish_at'
    ];

    /**
     * Boot method (eager load relationships)
     */
    protected static function boot()
    {
        parent::boot();

        // Eager load categories relationship
        static::addGlobalScope('categories', function ($builder) {
            $builder->with(['categories' => function ($query) {
                $query->published()->orderBy('parent', 'ASC');
            }]);
        });
        // Eager load brand relationship
        static::addGlobalScope('brand', function ($builder) {
            $builder->with(['brand' => function ($query) {
                $query->published()->orderBy('order', 'ASC');
            }]);
        });
        // Eager load attributes relationship
        static::addGlobalScope('attributes', function ($builder) {
            $builder->with(['attributes' => function ($query) {
                $query->published()->orderBy('order', 'ASC');
            }]);
        });
        // Eager load categories relationship
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
     * User one-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Brand one-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Categories many-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Attribute many-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    /**
     * Tags many-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
