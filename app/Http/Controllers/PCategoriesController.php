<?php namespace App\Http\Controllers;

use App\Brend;
use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Language;
use App\Osobina;
use App\PCategory;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use File;
use DB;

class PCategoriesController extends Controller {

	public function __construct(){
		$this->middleware('menager');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$slug = 'posts';
		$pcategories = PCategory::orderby('id', 'DESC')->paginate(50);
		return view('admin.pcategories.index', compact('cats', 'slug', 'pcategories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$slug = 'products';
		$catids = array();
		return view('admin.pcategories.create', compact('slug', 'catids'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\CreateCategoriesRequest $request)
	{
		$cat = PCategory::create($request->except('image'));
		$cat->slug = str_slug($request->input('title'));

		if($request->input('parent') > 0){
			$parent = PCategory::find($request->input('parent'));
			$cat->level = $parent->level + 1;
		}else{
			$cat->level = 1;
		}

        $cat->publish = $request->input('publish')?: 0;
		$cat->update();

		$cat->update(['image' => $cat->storeImage()]);

		return redirect('admin/pcategories')->with('done', 'Kategorija je kreirana. ');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	public function sortable()
	{
		$slug = 'products';
		return view('admin.pcategories.sortable', compact('slug'));
	}

    public function sortableUpdate()
    {
        $sort = Input::get('sortable');
        PCategory::save_cat_order($sort);
        return 'save';
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$slug = 'posts';
		$pcategory = PCategory::findOrFail($id);
		$catids = array($pcategory->parent);
		return view('admin.pcategories.edit', compact('pcategory', 'slug', 'catids'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Requests\UpdateCategoryLangRequest $request, $id)
	{
		$cat = PCategory::findOrFail($id);
		$cat->update(request()->all());

		if($request->input('parent') > 0){
			$parent = PCategory::find($request->input('parent'));
			$cat->level = $parent->level + 1;
			$cat->parent = $request->input('parent');
		}else{
			$cat->level = 1;
		}

        $cat->publish = request('publish')?: 0;
		$cat->update();

        $cat->update(['image' => $cat->storeImage()]);

		return redirect('admin/pcategories/'.$cat->id.'/edit')->with('done', 'Kategorija je izmenjena.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		/*Category::deleteCategory($id,$id);*/
		$category = PCategory::find($id);
		$category->delete();
		return redirect('admin/pcategories')->with('done', 'Kategorija je obrisana.');
	}

	public function publish($id){
		$val = Input::get('val');
		if($val == 'true'){ $primary = 1; }else{ $primary = 0; }
		$cat = PCategory::find($id)->update(array('publish' => $primary));
		if(isset($cat)){ return 'da'; }else{ return 'ne'; }
	}

	public function deleteimg($id)
	{
		$cat = PCategory::find($id);
		File::delete($cat->image);
		$cat->image = '';
		$cat->update();
		return view('admin.pcategories.image_append');
	}

	public function search(Request $request){
		$title = $request->input('title');
		Session::set('category_title', $title);
		$cats = PCategory::where('title', 'LIKE', '%'.$title.'%')->orWhere('slug', 'LIKE', '%'.$title.'%')->get();
		return view('admin.pcategories.index_append', compact('cats'));
	}

	public function showCategory($id){
		Category::showProductByCategory($id, true);
		return redirect()->back()->with('done', 'Proizvodi sa prikazani');
	}

	public function hideCategory($id){
		Category::showProductByCategory($id, false);
		return redirect()->back()->with('done', 'Proizvodi sa sakriveni');
	}

	public function removeSearch(){
		Session::forget('category_title');
		return redirect('admin/categories');
	}

}
