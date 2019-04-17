<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\Product;
use App\Traits\SEO;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    use SEO;

    /**
     * Handles displaying shop page with filters and results.
     *
     * @param $categories
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shopCategory($categories, Product $product)
    {
        // Get category object
        $category = Category::getCategoryByUrl($categories);

        // If there is no category for given url, check if last parameter in url is product slug
        if (!$category) {
            $urlParameters = collect (explode('/', $categories));

            // Take last two parameters which are product slug and product code
            // and pass it separately to product method
            $productSlugAndCode = $urlParameters->take(-2);

            return $this->product($categories, $productSlugAndCode->first(), $productSlugAndCode->last());
        }

        // Seo optimization
        $this->seoCategory($category);

        // Filter products and return filtered products attributes and price.
        $data = $product->filter($category);
        $products = $data['products'];
        $properties = $category->properties;

        return view('pages.shop', [
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
     * @param $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product($categories, $slug, $code)
    {
        // Retrieve product by dynamic number of categories and product slug.
        $product = Product::getProductByUrl($categories, $slug, $code);
        // return 404 page if there is no product for given url.
        if (!$product) {
            return abort(404);
        }
        // Append gallery for product
        $product->gallery->each->append(['gallery_image', 'product_thumbnail']);

        // Set seo optimization.
        $this->seoProduct($product);

        return view('pages.product', [
            'product' => $product
        ]);
    }
}
