<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Http\Requests\CreateBrandRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(15);
        return response()->json([
            'brands' => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBrandRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBrandRequest $request)
    {
        $brand = Brand::create($request->all());
        return response()->json([
            'message' => 'Uspešno kreiran brend!',
            'brand' => $brand
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return response()->json([
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $brand->update($request->all());
        return response()->json([
            'brand' => $brand,
            'message' => 'Uspešno ažuriran brend!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json([
            'message' => 'Brend je uspešno obrisan'
        ]);
    }

    /**
     * Return list of brands as id-title.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {
        $brands = Brand::select('id', 'title')->orderBy('title')->get();

        return response()->json([
            'brands' => $brands
        ]);
    }
}
