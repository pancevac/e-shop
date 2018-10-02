<?php

namespace App\Http\Controllers\Api;

use App\Attribute;
use App\Http\Requests\CreateAttributeRequest;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributesController extends Controller
{
    /**
     * AttributesController constructor.
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
        $attributes = Attribute::with('property')
            ->whereHas('property', function ($query) {
                $query->published();
            })
            ->orderBy('created_at', 'DESC')
            ->paginate();

        return response()->json([
            'attributes' => $attributes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAttributeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAttributeRequest $request)
    {
        $attribute = Attribute::create($request->all());

        return response()->json([
            'message' => 'Atribut je uspešno kreiran.'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute = Attribute::with(['property' => function ($query) {
            $query->select('id', 'title');
        }])
            ->whereId($id)
            ->first();

        return response()->json([
            'attribute' => $attribute
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateAttributeRequest $request
     * @param Attribute $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(CreateAttributeRequest $request, Attribute $attribute)
    {
        $attribute->update($request->all());

        return response()->json([
            'message' => 'Attribut je uspešno ažuriran.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Attribute $attribute
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response()->json([
            'message' => 'Attribut je uspešno izbrisan.'
        ]);
    }

    /**
     * Filter attributes list based on property and page number...
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search()
    {
        $attributes = Attribute::with('property')

            // Filter attributes based on searchable text
            ->where(function ($query) {
                if (request('text')) {
                    $query->where('title', 'like', '%' . request('text') . '%')->orWhere('slug', 'like', '%' . request('text') . '%');
                }
            })

            // Filter attributes based on property
            ->where(function ($query) {
                if (request('option') > 0) {
                    $query->where('property_id', request('option'));
                }
            })
            ->paginate();

        return response()->json([
            'attributes' => $attributes
        ]);
    }
}
