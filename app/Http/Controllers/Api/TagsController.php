<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateTagRequest;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * TagsController constructor.
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
        $tags = Tag::paginate();

        return response()->json([
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTagRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagRequest $request)
    {
        Tag::create($request->all());

        return response()->json([
            'message' => 'Tag je uspešno kreiran!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Tag $tag)
    {
        return response()->json([
            'tag' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateTagRequest|Request $request
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTagRequest $request, Tag $tag)
    {
        $tag->update($request->all());
        return response()->json([
            'message' => 'Tag je uspešno ažuriran.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json([
            'message' => 'tag je uspešno izbrisan.'
        ]);
    }
}
