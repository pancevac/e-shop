<?php

namespace App;

use App\Traits\UploadableImageTrait;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use UploadableImageTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'button_text', 'link', 'image', 'type', 'active'];

    /**
     * Get latest active widgets for home page
     *
     * @param int $take
     * @return mixed
     */
    public static function getHomeWidgets($take = 2)
    {
        return self::active()->type('home')->orderByDesc('updated_at')->take($take)->get();
    }

    /**
     * Return widget image.
     *
     * @return string
     */
    public function getImage()
    {
        return \Imagecache::get($this->image, 'home_widget')->src;
    }

    /**
     * Return widget link
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getLink()
    {
        return url($this->link);
    }

    /**
     * Filter only active widgets
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Filter widget type
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeType($query, $value)
    {
        return $query->where('type', $value);
    }
}
