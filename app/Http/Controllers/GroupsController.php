<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\CreateGroupRequest;
use App\Product;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function __construct(){
        $this->middleware('menager');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slug = 'products';
        $groups = Group::orderBy('created_at', 'DESC')->paginate(50);
        return view('admin.groups.index', compact('slug', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'products';
        $products = Product::listsTranslations('title', 'id')->pluck('title', 'id');
        return view('admin.groups.create', compact('slug', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGroupRequest $request)
    {
        $group = Group::create($request->all());
        $request->input('publish')? $group->publish = 1 : $group->publish = 0;
        $group->update();

        request('products')? $group->product()->sync(request('products')) : $group->product()->sync([]);

        return redirect('admin/groups')->with('done', 'Grupa je kreirana');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slug = 'products';
        $group = Group::find($id);
        $products = Product::listsTranslations('title', 'id')->pluck('title', 'id');
        $productIds = $group->product()->pluck('products.id');
        return view('admin.groups.edit', compact('slug', 'group', 'products', 'productIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(CreateGroupRequest $request, $id)
    {
        $group = Group::find($id);
        $group->update($request->all());
        $request->input('publish')? $group->publish = 1 : $group->publish = 0;
        $group->update();

        request('products')? $group->product()->sync(request('products')) : $group->product()->sync([]);

        return redirect('admin/groups/'.$group->id.'/edit')->with('save', 'Grupa je izmenjena');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        Group::find($id);
        return redirect('admin/groups')->with('save', 'Grupa je obrisana');
    }

    public function publish($id){
        $val = request('val');
        if($val == 'true'){ $primary = 1; }else{ $primary = 0; }
        $group = Group::find($id)->update(array('publish' => $primary));
        if(isset($group)){ return 'da'; }else{ return 'ne'; }
    }
}
