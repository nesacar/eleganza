<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\PCategory;
use App\PCategoryTranslation;
use App\Http\Requests\CreateCategoriesRequest;
use App\Http\Requests\UpdateCategoryLangRequest;
use App\Language;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use File;
use DB;
use Session;

class CategoriesController extends Controller
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
        $slug = 'categories';
        Session::get('category_id')? $category_id = Session::get('category_id') : $category_id = 0;
        if($category_id == 0){
            $categories = Category::orderby('id', 'DESC')->paginate(Category::$list_limit);
        }else{
            $categories = Category::where('parent', $category_id)->orderby('id', 'DESC')->paginate(Category::$list_limit);
        }
        $cats = Category::where('level', '<', 4)->where('publish', 1)->orderBy('order', 'ASC')->pluck('title', 'id')->prepend('Sve kategorije', 0);
        return view('admin.categories.index', compact('slug', 'categories', 'cats', 'category_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'categories';
        $catids = [];
        $cats = Category::orderby('order', 'ASC')->get();
        $c = Category::where('publish', 1)->where('level', '<', 3)->pluck('title', 'id')->toArray();
        if(count($c)){
            $catids = $c;
        }
        $brands = Brand::where('publish', 1)->pluck('title', 'brands.id')->prepend('Bez brenda...', 0);
        return view('admin.categories.create', compact('slug', 'parents', 'catids', 'cats', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoriesRequest $request)
    {
        $category = Category::create($request->except('image'));
        $category->slug = str_slug($request->input('title'));
        $category->publish = request('publish')?: 0;
        $category->parent = request('parent')?: 0;
        $category->parent = request('level')?: 1;
        $category->update();

        $category->update(['image' => $category->storeImage()]);

        return redirect('admin/categories')->with('done', 'Kategorija je kreirana.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(PCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $slug = 'categories';
        $cats = Category::where('publish', 1)->pluck('title', 'id')->prepend('Bez kategorije...', 0);
        $catids = array($category->parent);
        $brands = Brand::where('publish', 1)->pluck('title', 'brands.id')->prepend('Bez brenda...', 0);
        return view('admin.categories.edit', compact('slug', 'category', 'parents', 'languages', 'cats', 'catids', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryLangRequest $request, Category $category)
    {
        $category->update(request()->except('image'));
        $category->publish = request('publish')?: 0;
        $category->update();

        $category->update(['image' => $category->storeImage()]);

        return redirect('admin/categories/'.$category->id.'/edit')->with('done', 'Kategorija je izmenjeno');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(PCategory $category)
    {
        //
    }

    public function delete($id)
    {
        if(\Auth::user()->role >= 2){
            $category = Category::find($id);
            if($category->image) File::delete($category->image);
            $category->delete();
            return redirect('admin/categories')->with('done', 'Kategorija je obrisana.');
        }else{
            return redirect('admin/categories')->with('done', 'Samo admin može obrisati kategoriju.');
        }
    }

    public function publish($id){
        $val = Input::get('val');
        if($val == 'true'){ $primary = 1; }else{ $primary = 0; }
        $category = Category::find($id)->update(array('publish' => $primary));
        if(isset($category)){ return 'da'; }else{ return 'ne'; }
    }

    public function sortable()
    {
        app()->setLocale('hr');
        $slug = 'categories';
        return view('admin.categories.sortable', compact('slug'));
    }

    public function sortableUpdate()
    {
        $sort = Input::get('sortable');
        Category::save_cat_order($sort);
        return 'save';
    }

    public function deleteImg($id){
        $category = Category::find($id);
        File::delete($category->image);
        $category->update(array('image' => null));
        return view('admin.categories.image_append');
    }

    public function search(Request $request){
        Session::put('category_id', $request->input('category_id'));
        return redirect('admin/categories');
    }

    public function properties($id){
        app()->setLocale('hr');
        $slug = 'categories';
        $category = Category::find($id);
        $properties = Property::where('publish', 1)->orderBy('order', 'ASC')->get();
        $ids = $category->property()->pluck('property_id')->toArray();
        return view('admin.categories.properties', compact('slug', 'category', 'properties', 'ids'));
    }

    public function propertiesPost(Request $request, $id){
        $category = Category::find($id);
        $request->input('properties')? $category->property()->sync($request->input('properties')) : $category->property()->sync([]);
        return redirect()->back()->with('done', 'Sačuvano');
    }
}
