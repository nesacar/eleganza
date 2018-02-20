<?php namespace App\Http\Controllers;

use App\Asortiman;
use App\Brand;
use App\Brend;
use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Language;
use App\Osobina;
use App\Property;
use Illuminate\Support\Facades\Input;
use App\Set;
use Illuminate\Http\Request;

class SetsController extends Controller {

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
		$slug = 'sets';
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
		$sets = Set::all();
		return view('admin.sets.index', compact('sets','slug'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$slug = 'sets';
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
		//$asortimen = Asortiman::lists('title', 'id');
		//$brends = Brand::lists('title', 'id');
		return view('admin.sets.create', compact('slug'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\CreateBrandRequest $request)
	{
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
	    $set = new Set();
	    $set->title = $request->input('title');
	    $set->slug = str_slug($request->input('title'));
	    $request->input('publish')? $set->publish = 1 : $set->publish = 0;
        $set->save();
        return redirect('admin/sets')->with('save', 'Set je kreiran.');
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

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$slug = 'sets';
		$set = Set::find($id);
        $languages = Language::where('publish', 1)->orderBy('order', 'ASC')->get();
		return view('admin.sets.edit', compact('slug', 'set', 'languages'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
		$set = Set::find($id);
        $request->input('publish')? $set->publish = 1 : $set->publish = 0;
        $set->update();
        return redirect('admin/sets/'.$set->id.'/edit')->with('save', 'Set je izmenjen.');
	}

    public function updateLang(Requests\CreateBrandRequest $request, $id)
    {
        $primary = Language::getPrimary();
        $request->input('locale')? $locale = $request->input('locale') : $locale = $primary->locale;
        app()->setLocale($locale);
        $set = Set::find($id);
        $set->title = $request->input('title');
        $set->slug = str_slug($request->input('title'));
        $set->update();
        return redirect('admin/sets/'.$set->id.'/edit')->with('done', 'Set je izmenjen');
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

	public function delete($id)
	{
		Set::find($id)->delete();
		return redirect('admin/sets')->with('save', 'Set je obrisan.');
	}

	public function publish($id){
		$val = request('val');
		if($val == 'true'){ $publish = 1; }else{ $publish = 0; }
		$set = Set::find($id)->update(array('publish' => $publish));
		if(isset($set)){ return 'da'; }else{ return 'ne'; }
	}

	public function attributes($id)
	{
		$slug = 'sets';
		$set = Set::find($id);
		return view('admin.sets.attributes', compact('slug', 'set'));
	}

	public function attributeUpdate($id){
		$set = Set::find($id);
		if(request('atts') == null){
			$set->attribute()->sync([]);
		}else{
			$set->attribute()->sync(request('atts'));
		}
		return redirect()->back();
	}

	public function properties($id)
	{
		$slug = 'sets';
		$set = Set::find($id);
		$properties = Property::where('publish', 1)->get();
		$propertyIds = $set->property()->pluck('properties.id')->toArray();
		return view('admin.sets.properties', compact('slug', 'set', 'properties', 'propertyIds'));
	}

	public function propertyUpdate($id){
		$set = Set::find($id);
		if(request('properties') == null){
			$set->property()->sync([]);
		}else{
			$set->property()->sync(request('properties'));
		}
		return redirect()->back();
	}

}
