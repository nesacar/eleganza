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
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $posts = Post::filteredPosts(Session::get('post_title'), Session::get('post_cat'));
        $categories = PCategory::listsTranslations('title', 'id')->pluck('title', 'id')->prepend('Sve kategorije', 0);
        return view('admin.posts.index', compact('slug', 'posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $slug = 'posts';
        $categories = PCategory::listsTranslations('title', 'id')->pluck('title', 'id');
        $tags = Tag::getTagSelect('sr');
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
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $post = \Auth::user()->post()->save(new Post($request->all()));
        request('home')? $post->home = 1 : $post->home = 0;
        request('publish')? $post->publish = 1 : $post->publish = 0;

        $post->title = request('title');
        $post->slug = str_slug(request('title'));
        $post->short = request('short');
        $post->body = request('body');

        if(request('tags') == null){
            $post->tag()->sync([]);
        }else{
            $tagovi = Tag::addTags(request('tags'), 'sr');
            $post->tag()->sync($tagovi);
        }

        if($request->hasFile('image')){
            $imageName = $post->slug . '-' . $post->id . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = 'images/posts/'.$imageName;
            $imagePathTmb = 'images/posts/tmb/'.$imageName;
            $request->file('image')->move(base_path() . '/public/images/posts/', $imageName);
            $post->image = $imagePath;
            $post->tmb = $imagePathTmb;

            $post->update();

            File::copy($imagePath, $imagePathTmb);

            $tmb = \Image::make($post->tmb);
            $tmb->fit(1080, 500);
            $tmb->save();
        }

        $post->update();

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
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $categories = PCategory::listsTranslations('title', 'id')->pluck('title', 'id');
        $tags = Tag::getTagSelect('sr');
        $tag_ids = $post->tag->pluck('id')->toArray();
        $languages = Language::where('publish', 1)->orderBy('order', 'ASC')->get();
        $catids = PCategory::select('p_categories.*')->join('p_category_post', 'p_categories.id', '=', 'p_category_post.p_category_id')
            ->where('p_category_post.post_id', $post->id)->pluck('p_categories.id')->toArray();
        return view('admin.posts.edit', compact('slug', 'post', 'categories', 'tag_ids', 'tags', 'languages', 'catids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePostRequest $request, Post $post)
    {
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $post->update($request->all());
        $request->input('home')? $post->home = 1 : $post->home = 0;
        $request->input('publish')? $post->publish = 1 : $post->publish = 0;

        if($request->hasFile('image')){
            $imageName = $post->slug . '-' . $post->id . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = 'images/posts/'.$imageName;
            $imagePathTmb = 'images/posts/tmb/'.$imageName;
            $request->file('image')->move(base_path() . '/public/images/posts/', $imageName);
            $post->image = $imagePath;
            $post->tmb = $imagePathTmb;

            File::copy($imagePath, $imagePathTmb);

            $tmb = \Image::make($post->tmb);
            $tmb->fit(1080, 500);
            $tmb->save();
        }

        $post->update();

        $post->pcategory()->sync(request('kat'));

        if($request->input('tags') == null){
            $post->tag()->sync([]);
        }else{
            $tagovi = Tag::addTags($request->input('tags'), 'sr');
            $post->tag()->sync($tagovi);
        }
        return redirect('admin/posts/'.$post->id.'/edit')->with('done', 'Članak je izmenjen');
    }

    public function updateLang(UpdatePostLangRequest $request, $id)
    {
        //return $request->all();
        $primary = Language::getPrimary();
        $request->input('locale')? $locale = $request->input('locale') : $locale = $primary->locale;
        app()->setLocale($locale);
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->slug = str_slug($request->input('title'));
        $post->short = $request->input('short');
        $post->body = $request->input('body');

        $post->update();

        return redirect()->back()->with('done', 'Članak je izmenjen');
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
        $post->update(array('image' => null));
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
