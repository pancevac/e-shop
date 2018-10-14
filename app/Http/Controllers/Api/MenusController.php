<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateMenuRequest;
use App\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'menus' => Menu::paginate(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateMenuRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMenuRequest $request)
    {
        Menu::create($request->all());
        return response()->json([
            'message' => 'Uspešno kreiran tip menija!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return response()->json([
            'menu' => $menu,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateMenuRequest $request
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(CreateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->all());
        return response()->json([
            'message' => 'Uspešno ažuriran tip menija!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->json([
            'message' => 'Tip menija je uspešno obrisan'
        ]);
    }
}
