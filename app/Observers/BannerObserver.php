<?php

namespace App\Observers;

use App\Banner;

class BannerObserver
{
    /**
     * Handle the banner "created" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */
    public function created(Banner $banner)
    {
        // If banner is checked as active, change rest banners active status to false
        if ($banner->id && $banner->active) {

            Banner::where('id', '!=', $banner->id)
                ->update(['active' => 0]);
        }
    }

    /**
     * Handle the banner "updated" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */
    public function updated(Banner $banner)
    {
        // If banner is checked as active, change rest banners active status to false
        if ($banner->id && $banner->active) {

            Banner::where('id', '!=', $banner->id)
                ->update(['active' => 0]);
        }
    }

    /**
     * Handle the banner "deleted" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */
    public function deleted(Banner $banner)
    {
        //
    }

    /**
     * Handle the banner "restored" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */
    public function restored(Banner $banner)
    {
        //
    }

    /**
     * Handle the banner "force deleted" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */
    public function forceDeleted(Banner $banner)
    {
        //
    }
}
