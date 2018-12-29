<?php
/**
 * Created by PhpStorm.
 * User: sile
 * Date: 22.10.18.
 * Time: 23.11
 */

namespace App\Traits;


trait ShopFilterTrait
{

    public function filter($category = false)
    {
        // Initialize query builder of model that trait uses
        $query = $this->newQuery();
        foreach (request()->all() as $key => $attribute) {

            if (in_array($key, $this->searchable)) {

                $query->$key($attribute);
            }
        }

        if ($category) {
            $query->categoryFilter($category);
        }

        // Get min-max price ranges
        $minPrice = 0;
        $maxPrice = $category ? $this->getMaxPrice($category) : $this->query()->max('price');

        // Get slider selected price ranges
        $minPriceSelected = (int) $this->isPriceInRequest() ? request('price')[0] : 0;
        $maxPriceSelected = (int) $this->isPriceInRequest() ? request('price')[1] : $maxPrice;


        return [
            'products' => $query->paginate($this->shopPaginate),
            'attributesIds' => request()->get('filters'),
            'minPrice' => (int) $minPrice,
            'maxPrice' => (int) $maxPrice,
            'minPriceSelected' => (int) $minPriceSelected,
            'maxPriceSelected' => (int) $maxPriceSelected,
            'price' => '',
        ];
    }

    public function scopeFilters($query, $attributesIds)
    {
        return $query->whereHas('attributes', function ($attributes) use ($attributesIds) {
            $attributes
                ->whereIn('attributes.id', $attributesIds)
                ->groupBy('products.code')
                ->havingRaw('COUNT(DISTINCT attributes.id) = ' . count($attributesIds));
        });
    }

    public function scopeCategoryFilter($query, $category)
    {
        return $query->whereHas('categories', function ($query) use ($category) {
            $query->whereId($category->getKey());
        });
    }

    public function scopeBrand($query, $brandId)
    {
        return $query->whereHas('brand', $brandId);
    }

    public function scopePrice($query, $price)
    {
        if (count($price)) {
            return $query->whereBetween('price', [$price[0], $price[1]]);
        }
        return $query;
    }

    public function scopeSort($query, $sort = 1)
    {
        if (is_numeric($sort)) {
            if ($sort == 1) {
                $query->orderBy('title');
            }
            if ($sort == 2) {
                $query->orderBy('price');
            }
            if ($sort == 3) {
                $query->orderBy('price', 'DESC');
            }
            return $query;
        }
    }

    public function scopeShow($query, $paginate)
    {
        //$this->$shopPaginate = $paginate;
    }

    public function isPriceInRequest()
    {
        return request('price') && count(request('price')) == 2;
    }

    public function getMaxPrice($category)
    {
        return $this->query()->CategoryFilter($category)->max('price');
    }


}