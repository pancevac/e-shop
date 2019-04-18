<?php
/**
 * Created by PhpStorm.
 * User: Sile
 * Date: 4/18/2019
 * Time: 1:24 AM
 */

namespace App\Http\ViewComposers;

use App\Helpers\BasicHelper;
use App\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TopSalesComposer
{
    /**
     * @var
     */
    protected $products;

    /**
     * TopSalesComposer constructor.
     */
    public function __construct()
    {
        $this->products = Cache::remember('topSales', BasicHelper::getMinutesToTheNextHour(), function () {
            return $this->getTopSales();
        });
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('topSales', $this->products);
    }

    /**
     * Get best-selling products.
     *
     * @return Collection
     */
    protected function getTopSales()
    {
        $productsIds = \DB::table('order_product')
            ->select('order_product.product_id', \DB::raw('COUNT(order_product.product_id) AS product_count'))
            ->groupBy('order_product.product_id')
            ->orderBy('product_count', 'DESC')
            ->limit(12)
            ->get()
            ->pluck('product_id')
            ->toArray();

        $products = Product::withoutGlobalScopes(['brand', 'attributes'])
            ->findMany($productsIds);

        return $products->sortBy(function (Product $model) use ($productsIds) {
            return array_search($model->getKey(), $productsIds);
        });
    }
}