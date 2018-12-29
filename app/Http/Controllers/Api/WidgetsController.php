<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateWidgetRequest;
use App\Http\Requests\UploadImageRequest;
use App\Widget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WidgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'widgets' =>  $widgets = Widget::orderByDesc('updated_at')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateWidgetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateWidgetRequest $request)
    {
        $widget = Widget::create($request->except('image'));

        return response()->json([
            'widget' => $widget,
            'message' => 'Widget je uspešno kreiran!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Widget $widget
     * @return \Illuminate\Http\Response
     */
    public function edit(Widget $widget)
    {
        return response()->json([
            'widget' =>  $widget,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateWidgetRequest $request
     * @param Widget $widget
     * @return \Illuminate\Http\Response
     */
    public function update(CreateWidgetRequest $request, Widget $widget)
    {
        $widget->update($request->except('image'));

        return response()->json([
            'widget' => $widget,
            'message' => 'Widget je uspešno ažuriran.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Widget $widget
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Widget $widget)
    {
        $widget->delete();

        return response()->json([
            'message' => 'Widget je uspešno izbrisan.'
        ]);
    }

    /**
     * Upload widget image
     *
     * @param UploadImageRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(UploadImageRequest $request, $id)
    {
        $widget = Widget::find($id);
        $widget->update([
            'image' => $widget->storeImage('image'),
        ]);

        return response()->json([
            'image' => $widget->image,
        ]);
    }
}
