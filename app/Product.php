<?php

namespace App;

use App\Traits\ShopFilterTrait;
use App\Traits\UploadableImageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use UploadableImageTrait;
    use ShopFilterTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'brand_id', 'title', 'slug', 'code', 'short', 'description', 'image', 'price', 'price_outlet', 'views', 'stock', 'featured', 'publish', 'publish_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['date', 'time', 'categoriesIds'];

    /**
     * The attributes that are used for filtering products.
     *
     * @var array
     */
    protected static $searchable = ['filters', 'price', 'sort', 'show'];

    public static $frontPaginate = 10;

    public static $shopPaginate = 10;

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
     * Return product generated link.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getLink()
    {
        $link = 'shop/';
        $categories = Category::removeDuplicatesFromCollection($this->categories);

        foreach ($categories as $category) {
            $link .= $category->slug . '/';
        }

        return url($link . $this->slug);
    }

    /**
     * Get product based on requested url.
     *
     * @param $categories
     * @param $slug
     * @return mixed
     */
    public static function getProductByUrl($categories, $slug)
    {
        return self::with('gallery')
            ->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('slug', explode('/', $categories));
            })
            ->whereSlug($slug)
            ->first();
    }

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
     * Get the label flag for date.
     *
     * @return string
     */
    public function getDateAttribute()
    {
        return Carbon::parse($this->publish_at)->format('Y-m-d');
    }

    /**
     * Get the label flag for time.
     *
     * @return string
     */
    public function getTimeAttribute()
    {
        return Carbon::parse($this->publish_at)->format('H:00:00');
    }

    /**
     * Get the label flag for product categories ids...
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCategoriesIdsAttribute()
    {
        return $this->categories()->pluck('id');
    }

    /**
     * Get the label flag for selected attributes ids...
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSelectedAttributesAttribute()
    {
        return $this->attributes['selectedAttributes'] = $this->attributes()->pluck('id');
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

    /**
     * Gallery one-to-many relationship. Every product can have gallery images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }
}
