<?php
/**
 * Created by PhpStorm.
 * User: sile
 * Date: 19.10.18.
 * Time: 03.16
 */

namespace App\Http\ViewComposers;


use App\Category;
use App\Helpers\BasicHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoryComposer
{
    protected $categories;

    public function __construct()
    {
        $this->categories = Cache::remember('shopCategories', BasicHelper::getMinutesToTheNextHour(), function () {
            return Category::getCategorySort();
        });
    }

    public function compose(View $view)
    {
        $view->with('categories', $this->categories);
    }
}