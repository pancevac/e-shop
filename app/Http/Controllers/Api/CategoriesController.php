<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class CategoriesController extends Controller
{
    /**
     * CategoriesController constructor.
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
        $categories = Category::with('parentCategory')
            ->withoutGlobalScopes()
            ->orderBy('order')
            ->paginate();

        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = Category::create($request->all());
        return response()->json([
            'category' => $category,
            'message' => 'Kategorija je uspešno kreirana!'
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
        $category = Category::with(['parentCategory' => function ($query) {
            $query->withoutGLobalScopes()->select('id', 'title');
        }])
            ->whereId($id)
            ->first();

        return response()->json([
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateCategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        return response()->json([
            'category' => $category,
            'message' => 'Kategorija je uspešno ažurirana'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Kategorija je uspesno obrisana'
        ]);
    }

    public function lists()
    {
        $category = new Category();

        $lists = new Collection();

        foreach ($category->getCategories() as $option) {
            $lists = $lists->merge(collect([
                ['id' => $option['id'], 'title' => $option['title']]
            ]));
        }

        return response()->json([
            'categories' => $category->getCategories(),
            'lists' => $lists->pluck('title', 'id')->prepend('Izaberite kategoriju', 0)
        ]);
    }

    public function sort()
    {
        return response()->json([
            'categories' => Category::getCategorySort()
        ]);
    }

    public function saveOrder(Request $request)
    {
        Category::saveOrder($request->get('categories'));

        return response()->json([
            'categories' => Category::getCategorySort(),
            'message' => 'Raspored kategorija uspešno sačuvan'
        ]);
    }
}
