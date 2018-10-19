<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateMenuLinkRequest;
use App\MenuLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuLinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuLinks = MenuLink::with('menu')
            ->whereHas('menu', function ($query) {
                $query->where('id', request('id'));
            })
            ->paginate();

        return response()->json([
            'menuLinks' => $menuLinks
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
     * @param CreateMenuLinkRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMenuLinkRequest $request)
    {
        MenuLink::create($request->all());
        return response()->json([
            'message' => 'Link je uspešno kreiran!'
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
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menuLink = MenuLink::with('parent')->whereId($id)->first();

        return response()->json([
            'menuLink' => $menuLink,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateMenuLinkRequest $request
     * @param MenuLink $menuLink
     * @return \Illuminate\Http\Response
     */
    public function update(CreateMenuLinkRequest $request, MenuLink $menuLink)
    {
        $menuLink->update($request->all());
        return response()->json([
            'message' => 'Link je uspešno ažuriran.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MenuLink $menuLink
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(MenuLink $menuLink)
    {
        $menuLink->delete();
        return response()->json([
            'message' => 'Link je uspešno obrisan.'
        ]);
    }

    /**
     * Return list of menu-links as id-title.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {
        $menuLinks = MenuLink::select('id', 'title')

            ->whereHas('menu', function ($query) {

                if (request()->has('menu_id') && request('menu_id') > 0) {
                    $query->whereId(request('menu_id'));
                }
            })

            ->where(function ($query) {

                if (request()->has('except')) {
                    $query->where('id', '!=', request('except'));
                }
            })

            ->orderBy('title')
            ->get();

        return response()->json([
            'menuLinks' => $menuLinks
        ]);
    }

    /**
     * Return sorted nested structure.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort()
    {
        return response()->json([
            'menuLinks' => MenuLink::getMenuLinkSort(request('menu_id')),
        ]);
    }

    /**
     * Save sorted nested structure and returned updated one.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveSort(Request $request, $menuId)
    {
        MenuLink::saveMenuLinkSort($request->get('menuLinks'));

        return response()->json([
            'menuLinks' => MenuLink::getMenuLinkSort($menuId),
            'message' => 'Raspored linkova uspešno sačuvan.'
        ]);
    }
}
