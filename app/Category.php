<?php

namespace App;

use App\Traits\UploadableImageTrait;
use Illuminate\Database\Eloquent\Model;
use Lcobucci\JWT\Builder;

class Category extends Model
{

    use UploadableImageTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'seo_title', 'seo_keywords', 'seo_description', 'image', 'order', 'parent', 'level','featured', 'publish'
    ];

    /**
     * Category array in which nested categories will be stored when recursive method is called.
     *
     * @var
     */
    public $categories;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['label'];

    /**
     * Boot method of model, executed every time category class is initialized.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('childrenCategories', function ($builder) {
            $builder->with(['children' => function ($query) {
                $query->published()->orderBy('order');
            }]);
        });
    }

    /**
     * Get categories list with id, title...
     *
     * @param int $parent
     * @return mixed
     */
    public function getCategories($parent = 0)
    {
        $str = '-';
        $categories = $this->where('parent', $parent)->get();

        foreach ($categories as $category) {

            $this->categories[] = [
                'id' => $category->id,
                'title' => str_repeat($str, $category->level) . ' ' . $category->title,
            ];

            if ($category->children()->exists()) {

                $this->getCategories($category->id);
            }
        }

        return $this->categories;
    }

    /**
     * Get categories for sorting...
     *
     * @return mixed
     */
    public static function getCategorySort()
    {
        return self::where('parent', 0)->published()->orderBy('order')->get();
    }

    /**
     * Save categories nested structure.
     *
     * @param $links
     * @param int $parent
     * @param int $level
     * @param int $order
     */
    public static function saveOrder($links, $parent = 0, $level = 1, $order = 1)
    {
        foreach ($links as $link) {

            if (array_key_exists('children', $link)) {

                self::saveOrder($link['children'], $link['id'], $level + 1);
            }

            Category::where('id', $link['id'])
                ->update([
                    'parent' => $parent,
                    'level' => $level,
                    'order' => $order,
                ]);

            $order++;
        }
    }

    /**
     * Avoid repeated categories by removing duplicates from $categories collection.
     *
     * @param $categories
     * @return mixed
     */
    public static function removeDuplicatesFromCollection($categories)
    {
        return $categories->unique('slug')->unique('parent');
    }

    /**
     * Return category generated link.
     *
     * @param bool $category
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getLink($category = false)
    {
        //
    }

    /**
     * Get category based on requested url.
     *
     * @param $categories
     * @return mixed
     */
    public static function getCategoryByUrl($categories)
    {
        $categories = collect (explode('/', $categories));

        // Check if url last parameter is product code,
        // that means url is meant to be for product
        // so return false
        if (Product::getProductByCode($categories->last())) return false;

        $query = self::query()->withoutGlobalScopes()->with(['parentRecursive', 'properties.attributes']);

        if ($categories->count() != 1) {
            // Remove last element from collection to get parent categories slugs
            $lastCategory = $categories->pop();
            // Set parent query
            $query->ofParent($categories->last());
            // Push back last elemenet
            $categories->push($lastCategory);
        }

        $query->whereSlug($categories->last());
        $category = $query->first();

        // Abort if number of categories parameters in url did not match the nesting level from table...
        if ($category->level != $categories->count())
            return abort(404);

        return $category;
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
     * Set parent and level mutators.
     *
     * @param $value
     */
    public function setParentAttribute($value)
    {
        $this->attributes['parent'] = $value ? $value : 0;

        if (request()->get('parent')) {
            $parentCategory = self::withoutGlobalScopes()->select('level')->where('id', request()->get('parent'))->first();
            $this->attributes['level'] = $parentCategory->level + 1;
        }
    }

    /**
     * Return as boolean value;
     *
     * @param $publish
     * @return bool
     */
    public function getPublishAttribute($publish)
    {
        return (bool) $publish;
    }

    /**
     * Get the label flag for category title.
     *
     * @return mixed
     */
    public function getLabelAttribute()
    {
        return $this->attributes['label'] = $this->title;
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
     * Dynamic scope of parent categories
     *
     * @param $query
     * @param $categorySlug
     */
    public function scopeOfParent($query, $categorySlug)
    {
        $query->whereHas('parentCategory', function ($parentQuery) use ($categorySlug) {
            $parentQuery->whereSlug($categorySlug);
        });
    }

    /**
     * Parent category relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentCategory()
    {
        return $this->hasOne(Category::class, 'id', 'parent');
    }

    /**
     * Children category relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenCategory()
    {
        return $this->hasMany(Category::class, 'parent', 'id');
    }

    /**
     * Parent recursive relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentRecursive()
    {
        return $this->parentCategory()->withoutGlobalScopes()->with('parentRecursive');
    }

    /**
     * Children recursive relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->childrenCategory()->with('children');
    }

    /**
     * Property many-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
