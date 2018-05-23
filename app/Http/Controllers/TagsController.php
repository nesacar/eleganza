<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditTagRequest;
use App\Language;
use App\Tag;
use App\TagTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    private static $num = 50;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slug = 'posts';
        $tags = Tag::select('id', 'title')->orderBy('title', 'ASC')->paginate(self::$num);
        $sum = Tag::count();
        return view('admin.tags.index',compact('tags', 'slug', 'sum'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function create(Tag $tag)
    {
        $slug = 'posts';
        return view('admin.tags.create', compact('tag', 'slug'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function store(EditTagRequest $request)
    {
        $tag = Tag::create($request->all());
        $tag->slug = Str::slug($request->input('title'));
        $tag->update();
        return redirect('admin/tags')->with('done', 'Tag je kreiran.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $slug = 'posts';
        return view('admin.tags.edit', compact('tag', 'slug'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(EditTagRequest $request, Tag $tag)
    {
        $tag->update($request->all());
        $tag->slug = Str::slug($request->input('name'));
        $tag->update();
        return redirect('admin/tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        $tag = Tag::find($id);
        $tag->delete();
        return redirect('admin/tags');
    }
}
