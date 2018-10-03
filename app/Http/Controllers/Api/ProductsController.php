<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::withoutGlobalScope('brand')
            ->withoutGlobalScope('attributes')
            ->orderBy('id', 'DESC')
            ->paginate();

        return response()->json([
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProductRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        // Insert new product
        $product = Product::create($request->except('selectedCategories', 'selectedTags'));

        // Sync product's categories and tags...
        $product->categories()->sync($request->selectedCategories);
        $product->attributes()->sync($request->selectedAttributes);
        $product->tags()->sync($request->selectedTags);

        return response()->json([
            'message' => 'Proizvod je uspešno kreiran.'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit($id)
    {
        $product = Product::with('tags')->whereId($id)->first();

        return response()->json([
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditProductRequest|Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(EditProductRequest $request, Product $product)
    {
        // Update product
        $product->update($request->except('selectedCategories', 'selectedTags'));

        // Sync product's categories and tags...
        $product->categories()->sync($request->selectedCategories);
        $product->tags()->sync($request->selectedTags);

        return response()->json([
            'message' => 'Proizvod je uspešno ažuriran.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Proizvod je uspešno izbrisan.'
        ]);
    }
}
