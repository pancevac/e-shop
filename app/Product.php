<?php

namespace App;

use App\Traits\BuyableTrait;
use App\Traits\ShopFilterTrait;
use App\Traits\UploadableImageTrait;
use Actuallymab\LaravelComment\Commentable;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Product extends Model implements Buyable
{
    use UploadableImageTrait;
    use ShopFilterTrait;
    use Commentable;
    use BuyableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'brand_id',
        'title',
        'slug',
        'code',
        'short',
        'description',
        'image',
        'price',
        'price_outlet',
        'discount',
        'views',
        'stock',
        'featured',
        'publish',
        'publish_at'
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
    protected $searchable = ['filters', 'price', 'sort', 'show'];

    public $frontPaginate = 4;

    public $shopPaginate = 10;

    /**
     * Approve rating reviews/comments on this model.
     *
     * @var bool
     */
    protected $canBeRated = true;

    /**
     * Approve reviews/comments on this model.
     *
     * @var bool
     */
    protected $mustBeApproved = true;

    /**
     * Boot method (eager load relationships)
     */
    protected static function boot()
    {
        parent::boot();

        // Eager load categories relationship
        static::addGlobalScope('categories', function ($builder) {
            $builder->with(['categories' => function ($query) {
                $query->withoutGLobalScopes()->published()->orderBy('parent', 'ASC');
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
        $categories = Category::removeDuplicatesFromCollection($this->categories);

        return url($categories->pluck('slug')->prepend('shop')->push($this->slug)->push($this->code)->implode('/'));
    }

    /**
     * Get product based on requested url.
     *
     * @param $categories
     * @param $slug
     * @return mixed
     */
    public static function getProductByUrl($categories, $slug, $code)
    {
        return self::with(['categories.parentRecursive', 'gallery', 'attributes.property', 'comments.commented'])
            ->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('slug', explode('/', $categories));
            })
            ->whereSlug($slug)
            ->whereCode($code)
            ->first();
    }

    /**
     * Return products that are related by common categories.
     *
     * @return Collection
     */
    public function getRelated()
    {
        if (! $this->relationLoaded('categories')) {
            $this->load('categories');
        }

        return $this->withoutGlobalScopes(['brand', 'attributes'])
            ->whereHas('categories', function (Builder $relation) {
                $relation->whereIn('id', $this->categories->map->id->toArray());
            })
            ->where('id', '<>', $this->id)
            ->inRandomOrder()
            ->take(12)
            ->get();
    }

    /**
     * Check if product exist with given code
     *
     * @param $code
     * @return mixed
     */
    public static function checkProductByCode($code)
    {
        return self::published()->whereCode($code)->exists();
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
     * Set product code as slug.
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_slug($value);
    }

    public function setDiscountAttribute($value)
    {
        if ($value) {
            $this->attributes['discount'] = $value;
            $this->attributes['price_outlet'] = $this->price * ((100 - $value) / 100);
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

    public function getCartProductImageAttribute()
    {
        // 147*100
        return \Imagecache::get($this->image, 'cart_product_image')->src;
    }

    public function getProductWidgetAttribute()
    {
        // 370*395
        return \Imagecache::get($this->image, 'product_widget')->src;
    }

    public function getHomeProductAttribute()
    {
        // 255*271
        return \Imagecache::get($this->image, 'home_product')->src;
    }

    /**
     * Append product link
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getLinkAttribute()
    {
        return $this->getLink();
    }

    /**
     * Scope, filter only published
     *
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('publish', 1);
    }

    /**
     * Scope, filter only featured
     *
     * @param $query
     * @return mixed
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
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

    /**
     * The orders that belong to product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
