<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UploadImageRequest;
use App\Observers\BannerObserver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannersController extends Controller
{

    public function __construct()
    {
        Banner::observe(BannerObserver::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'banners' => Banner::orderByDesc('updated_at')->paginate(),
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
     * @param CreateBannerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBannerRequest $request)
    {
        $banner = Banner::create($request->except('image'));

        return response()->json([
            'banner' => $banner,
            'message' => 'Baner je uspešno kreiran!'
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
     * @param Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return response()->json([
            'banner' => $banner,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateBannerRequest $request
     * @param Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function update(CreateBannerRequest $request, Banner $banner)
    {
        $banner->update($request->except('image'));

        //$banner->syncActive();

        return response()->json([
            'banner' => $banner,
            'message' => 'Baner je uspešno ažuriran.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Banner $banner
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return response()->json([
            'message' => 'Widget je uspešno izbrisan.'
        ]);
    }

    /**
     * Upload widget image
     *
     * @param UploadImageRequest $request
     * @param Banner $banner
     * @return \Illuminate\Http\JsonResponse
     * @throws \ReflectionException
     */
    public function uploadImage(UploadImageRequest $request, Banner $banner)
    {
        $banner->update([
            'image' => $banner->storeImage('image'),
        ]);

        return response()->json([
            'image' => $banner->image,
        ]);
    }
}
