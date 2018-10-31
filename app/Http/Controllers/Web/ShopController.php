<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    /**
     * Handles displaying shop page with filters and results.
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shopCategory($slug)
    {
        // Get category object
        $category = Category::withoutGlobalScopes()->with('properties.attributes')->whereSlug($slug)->first();
        // Return 404 page if there is no category for given category slug in url.
        if (!$category) {
            return abort(404);
        }
        // Filter products and return filtered products attributes and price.
        $data = Product::filter($category);
        $products = $data['products'];
        $properties = $category->properties;

        return view('themes.'.env('APP_THEME').'.pages.shop', [
            'data' => $data,
            'products' => $products,
            'category' => $category,
            'properties' => $properties
        ]);
    }

    /**
     * Method that handles displaying product on product page.
     *
     * @param $categories
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product($categories, $slug)
    {
        // Retrieve product by dynamic number of categories and product slug.
        $product = Product::getProductByUrl($categories, $slug);
        // return 404 page if there is no product for given url.
        if (!$product) {
            return abort(404);
        }
        // Append gallery for product
        $product->gallery->each->append(['gallery_image', 'product_thumbnail']);

        return view('themes.'.env('APP_THEME').'.pages.product', [
            'product' => $product
        ]);
    }
}
