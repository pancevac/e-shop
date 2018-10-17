<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'menu_id', 'image', 'title', 'link', 'description', 'order', 'parent', 'level', 'visible'
    ];

    /********* Relations  ********/
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->hasOne(MenuLink::class, 'id', 'parent');
    }

    public function children()
    {
        return $this->hasMany(MenuLink::class, 'parent', 'id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /****** MUTATOR ******/

    public function setParentAttribute($value) {

        $this->attributes['parent'] = $value ? $value : 0;

        if (request()->get('parent')) {
            $parentMenuLink = self::select('level')->where('id', request()->get('parent'))->first();
            $this->attributes['level'] = $parentMenuLink->level + 1;
        }
    }
}
