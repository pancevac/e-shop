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

    public $appends = ['shop'];

    /********* Relations  ********/
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->hasOne(MenuLink::class, 'id', 'parent');
    }

    public function childrenMenuLink()
    {
        return $this->hasMany(MenuLink::class, 'parent', 'id');
    }

    public function children()
    {
        return $this->childrenMenuLink()->with('children');
    }

    /****** MUTATOR ******/

    public function setParentAttribute($value) {

        $this->attributes['parent'] = $value ? $value : 0;

        if (request()->get('parent')) {
            $parentMenuLink = self::select('level')->where('id', request()->get('parent'))->first();
            $this->attributes['level'] = $parentMenuLink->level + 1;
        }
    }

    /******** ACCESSORS *********/

    public function getShopAttribute()
    {
        if ($this->link) {
            $link = explode('/', $this->link);
            if (isset($link[1])) {
                return true;
            }
        }
    }

    /******** SCOPES *********/

    public function scopeVisible($query)
    {
        $query->whereVisible(1);
    }

    /******** METHODS *********/

    /**
     * Boot method of model, executed every time menuLink class is initialized.
     */
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('childrenMenuLinks', function ($builder) {
            $builder->with(['children' => function ($query) {
                $query->visible()->orderBy('order');
            }]);
        });
    }

    /**
     * Get menu-links for sorting...
     *
     * @param $menuId
     * @return mixed
     */
    public static function getMenuLinkSort($menuId)
    {
        return self::where('menu_id', $menuId)->where('parent', 0)->visible()->orderBy('order')->get();
    }

    /**
     * Save categories nested structure.
     *
     * @param $links
     * @param int $parent
     * @param int $level
     * @param int $order
     */
    public static function saveMenuLinkSort($links, $parent = 0, $level = 1, $order = 1)
    {
        foreach ($links as $link) {

            if (array_key_exists('children', $link)) {

                self::saveMenuLinkSort($link['children'], $link['id'], $level + 1);
            }

            MenuLink::where('id', $link['id'])
                ->update([
                    'parent' => $parent,
                    'level' => $level,
                    'order' => $order,
                ]);

            $order++;
        }
    }
}
