<?php

namespace App;

use App\Helpers\BasicHelper;
use App\Observers\BannerObserver;
use App\Traits\UploadableImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Banner extends Model
{
    use UploadableImageTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['image', 'image_text', 'button_text', 'link', 'active'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // Register observer on Banner boot
        self::observe(BannerObserver::class);
    }

    /**
     * Filter only active banner
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Return cached banner
     *
     * @return mixed
     */
    public static function getBanner()
    {
        return Cache::remember('home_banner', BasicHelper::getMinutesToTheNextHour(), function () {
            return self::active()->first();
        });
    }
}
