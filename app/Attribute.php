<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'order', 'additional', 'property_id', 'publish'
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
    protected $appends = ['label', 'idWithoutPrefix'];

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
     * Get the label flag for label title
     *
     * @return mixed
     */
    public function getLabelAttribute()
    {
        return $this->attributes['label'] = $this->title;
    }

    /**
     * Get the label flag for attribute id. This override real attr ID cuz of specific situation
     * on product edit api controller. Prefix "attributes" is added for unique ID to prevent collision with
     * property ID on same drop-down select field...
     *
     * @return string
     */
    public function getIdAttribute()
    {
        return $this->attributes['id'] = 'attribute.' . $this->attributes['id'];
    }

    /**
     * Return attribute ID without any prefix, just int.
     *
     * @return array|mixed
     */
    public function getIdWithoutPrefixAttribute()
    {
        return $this->getOriginal('id');
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
     * Property one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
