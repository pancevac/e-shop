<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'order', 'additional', 'publish'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    //protected $appends = ['label', 'children'];

    /**
     * Return properties that belongs to given categories with related attributes.
     *
     * @param $categoriesIds
     * @return Property[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getPropertiesByCategories($categoriesIds)
    {
        return self::with('attributes')
            ->select('id', 'title')
            ->whereHas('categories', function ($query) use ($categoriesIds) {
                $query->whereIn('id', $categoriesIds);
            })
            ->get()
            ->each
            ->append(['label', 'children']);
    }

    /**
     * Get the label flag for label title
     *
     * @return mixed
     */
    public function getLabelAttribute()
    {
        return $this->attributes['label'] = $this->title;
    }

    /**
     * Get the label flag children as attributes
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChildrenAttribute()
    {
        return $this->attributes['children'] = $this->attributes()->get();
    }

    /**
     * Set property slug, if slug field have value, make slug of it, otherwise make slug of title.
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
     * Categories many-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Attribute one-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
}
