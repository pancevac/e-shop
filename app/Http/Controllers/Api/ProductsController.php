<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Http\Requests\UploadImageRequest;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
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
        $product = Product::create($request->except('selectedCategories', 'selectedTags', 'image'));

        // Cut attribute prefix that makes attributes ID's unique to prevent conflict with property ID's.
        $selectedAttributes = [];
        foreach ($request->selectedAttributes as $attribute) {
            $selectedAttributes[] = explode('.', $attribute)[1];
        }

        // Sync product's categories and tags...
        $product->categories()->sync($request->selectedCategories);
        $product->attributes()->sync($selectedAttributes);
        $product->tags()->sync($request->selectedTags);

        return response()->json([
            'message' => 'Proizvod je uspešno kreiran.',
            'product' => $product,
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
            'product' => $product->append('selectedAttributes')
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
        // Cut attribute prefix that makes attributes ID's unique to prevent conflict with property ID's.
        $attributeIds = [];
        foreach ($request->selectedAttributes as $attribute) {
            $attributeIds[] = explode('.', $attribute)[1];
        }

        // Update product
        $product->update($request->except('selectedCategories', 'selectedTags', 'image'));

        // Sync product's categories and tags...
        $product->categories()->sync($request->selectedCategories);
        $product->attributes()->sync($attributeIds);
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
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Proizvod je uspešno izbrisan.'
        ]);
    }

    /**
     * Filter products list based on category and page number...
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search()
    {
        $products = Product::withoutGlobalScope('brand')
            ->withoutGlobalScope('attributes')

            // Filter products based on searchable text
            ->where(function ($query) {
                if (request('text')) {
                    $query->where('title', 'like', '%' . request('text') . '%')
                        ->orWhere('slug', 'like', '%' . request('text') . '%');
                }
            })

            // Filter products based on property
            ->where(function ($query) {
                if (request('option') > 0) {
                    $query->whereHas('categories', function ($categoryQuery) {
                        $categoryQuery->where('id', request('option'));
                    });
                }
            })

            ->orderBy('id', 'DESC')
            ->paginate();

        return response()->json([
            'products' => $products
        ]);
    }

    public function uploadImage(UploadImageRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update([
            'image' => $product->storeImage('image'),
        ]);

        return response()->json([
            'image' => $product->image,
        ]);
    }

    public function gallery($id)
    {
        $product = Product::withoutGlobalScopes()->whereId($id)->first();

        return response()->json([
            'gallery' => $product->gallery,
        ]);
    }

    public function uploadGallery($id)
    {
        Product::find($id)->storeGallery();
        return 'Done';
    }
}
