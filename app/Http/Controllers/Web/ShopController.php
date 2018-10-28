<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function shopCategory($slug)
    {
        $category = Category::withoutGlobalScopes()->with('properties.attributes')->whereSlug($slug)->first();
        //dd($category);
        $data = Product::filter($category);
        $products = $data['products'];
        $properties = $category->properties;

        return view('themes.fashiop.pages.shop', compact('data', 'products', 'category', 'properties'));
    }

    public function product()
    {

    }
}
