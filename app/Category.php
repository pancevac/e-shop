<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Lcobucci\JWT\Builder;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'seo_title', 'seo_keywords', 'seo_description', 'order', 'parent', 'level','featured', 'publish'
    ];

    public $categories;

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
        return self::where('parent', 0)->published()->get();
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
     * Scope published
     *
     * @param $query
     */
    public function scopePublished($query)
    {
        $query->where('publish', 1);
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
     * Children recursive relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->childrenCategory()->with('children');
    }
}
