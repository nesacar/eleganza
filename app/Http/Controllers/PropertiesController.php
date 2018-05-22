<?php namespace App\Http\Controllers;

use App\Attribute;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Language;
use App\Product;
use App\Property;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class PropertiesController extends Controller {

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
		$slug = 'products';
		$properties = Property::orderBy('id', 'DESC')->paginate(50);
		return view('admin.properties.index', compact('properties','slug'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$slug = 'products';
		$atributi = false;
		return view('admin.properties.create', compact('slug', 'atributi'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\CreatePropertyRequest $request)
	{
		$property = Property::create($request->all());
        $property->title = $request->input('title');
        $property->expanded = $request->input('expanded')?: 0;
        $property->publish = $request->input('publish')?: 0;
        $property->update();
		return redirect('admin/properties')->with('done', 'Osobina je kreirana.');
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
        $property = Property::find($id);
		$slug = 'products';
		$attributes = $property->attribute;
		return view('admin.properties.edit', compact('slug', 'attributes', 'property'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Requests\CreatePropertyRequest $request, $id)
	{
        $property = Property::find($id);
        $property->expanded = $request->input('expanded')?: 0;
        $property->publish = $request->input('publish')?: 0;
        $property->update();
        return redirect('admin/properties/'.$id.'/edit')->with('done', 'Osobina je izmenjena.');
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
        $property = Property::find($id);
        $property->delete();
		return redirect('admin/properties')->with('done', 'Osobina je obrisana.');
	}

	public function publish($id){
		$val = Input::get('val');
		if($val == 'true'){ $publish = 1; }else{ $publish = 0; }
        $property = Property::find($id)->update(array('publish' => $publish));
		if(isset($property)){ return 'da'; }else{ return 'ne'; }
	}

	public function sortable()
	{
		$slug = 'products';
		return view('admin.properties.sortable', compact('slug'));
	}

	public function sortable_ajax()
	{
		$sort = Input::get('sortable');
		Property::save_oso_order($sort);
		return 'save';
	}

}
