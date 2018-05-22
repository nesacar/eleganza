<?php

namespace App\Http\Controllers;

use App\PCategory;
use App\Http\Requests\CreatePostLangRequest;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostLangRequest;
use App\Language;
use App\Post;
use App\PostTranslation;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Session;

class PostsController extends Controller
{
    public function __construct(){
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
        $posts = Post::filteredPosts(Session::get('post_title'), Session::get('post_cat'));
        $categories = PCategory::pluck('title', 'id')->prepend('Sve kategorije', 0);
        return view('admin.posts.index', compact('slug', 'posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'posts';
        $categories = PCategory::pluck('title', 'id');
        $tags = Tag::pluck('title', 'id');
        $catids = [];
        return view('admin.posts.create', compact('slug', 'categories', 'tags', 'catids'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {

        $post = \Auth::user()->post()->save(new Post($request->except('image')));
        $post->home = request('home')?: 0;
        $post->publish = request('publish')?: 0;

        if(request('tags') == null){
            $post->tag()->sync([]);
        }else{
            $tagovi = Tag::addTags(request('tags'));
            $post->tag()->sync($tagovi);
        }

        $post->update();

        $post->update(['image' => $post->storeImage()]);

        $post->pcategory()->sync(request('kat'));

        return redirect('admin/posts')->with('done', 'Članak je kreiran.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $slug = 'posts';
        $categories = PCategory::pluck('title', 'id');
        $tags = Tag::pluck('title', 'id');
        $tag_ids = $post->tag->pluck('id')->toArray();
        $catids = PCategory::select('p_categories.*')->join('p_category_post', 'p_categories.id', '=', 'p_category_post.p_category_id')
            ->where('p_category_post.post_id', $post->id)->pluck('p_categories.id')->toArray();
        return view('admin.posts.edit', compact('slug', 'post', 'categories', 'tag_ids', 'tags', 'catids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostLangRequest $request, Post $post)
    {
        $post->update($request->except('image'));
        $post->home = request('home')? : 0;
        $post->publish = request('publish')?: 0;

        $post->update($request->except('image'));

        $post->pcategory()->sync($request->input('kat'));

        if($request->input('tags') == null){
            $post->tag()->sync([]);
        }else{
            $tagovi = Tag::addTags($request->input('tags'), 'sr');
            $post->tag()->sync($tagovi);
        }

        $post->update(['image' => $post->storeImage()]);

        return redirect('admin/posts/'.$post->id.'/edit')->with('done', 'Članak je izmenjen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function delete($id){
        $post = Post::find($id);
        File::delete($post->image);
        File::delete($post->tmb);
        $post->delete();
        //PostTranslation::where('post_id', $post->id)->delete();
        return redirect('admin/posts')->with('done', 'Članak je obrisan.');
    }

    public function publish($id){
        $val = Input::get('val');
        if($val == 'true'){ $primary = 1; }else{ $primary = 0; }
        $post = Post::find($id)->update(array('publish' => $primary));
        if(isset($post)){ return 'da'; }else{ return 'ne'; }
    }

    public function deleteimg($id){
        $post = Post::find($id);
        File::delete($post->image);
        File::delete($post->tmb);
        $post->update(array('image' => null, 'tmb' => null));
        return view('admin.posts.image_append');
    }

    public function search(Request $request){
        if(!empty($request->input('post_title'))){
            \Session::put('post_title', $request->input('post_title'));
        }else{
            \Session::forget('post_title');
        }
        if(!empty($request->input('post_cat'))){
            \Session::put('post_cat', $request->input('post_cat'));
        }else{
            \Session::forget('post_cat');
        }
        return redirect('admin/posts');
    }
}
