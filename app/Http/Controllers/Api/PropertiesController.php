<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreatePropertyRequest;
use App\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertiesController extends Controller
{
    /**
     * PropertiesController constructor.
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
        $properties = Property::with('categories')->orderBy('order')->paginate();

        return response()->json([
            'properties' => $properties
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePropertyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePropertyRequest $request)
    {
        // Insert new property
        $property = Property::create($request->except('categories'));
        // Sync property with categories
        $property->categories()->sync($request->get('categories'));

        return response()->json([
            'message' => 'Osobina je uspešno kreirana!',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::with([
            'categories' => function ($query) {
                $query->withoutGlobalScopes()->select('id', 'title');
            },
            'attributes'
        ])
            ->whereId($id)
            ->first();

        return response()->json([
            'property' => $property
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreatePropertyRequest $request
     * @param Property $property
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePropertyRequest $request, Property $property)
    {
        $property->update($request->except('categories'));
        $property->categories()->sync($request->get('categories'));

        return response()->json([
            'message' => 'Osobina je uspešno ažurirana.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Property $property
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return response()->json([
            'message' => 'Osobina je uspešno izbrisana.'
        ]);
    }

    /**
     * Return list of properties as id-title.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {
        $properties = Property::select('id', 'title')->orderBy('title')->get();

        return response()->json([
            'properties' => $properties
        ]);
    }
}
