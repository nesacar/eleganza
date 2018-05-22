<?php

namespace App\Http\Controllers;

use App\Block;
use App\Box;
use App\Http\Requests\CreateBoxRequest;
use App\Language;
use App\Http\Requests\CreateBlockRequest;
use Illuminate\Http\Request;
use File;

class BoxesController extends Controller
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
        $slug = 'blocks';
        $boxes = Box::orderby('created_at', 'DESC')->paginate(50);
        return view('admin.boxes.index', compact('boxes','slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $slug = 'blocks';
        $blocks = Block::where('publish', 1)->orderBy('title', 'ASC')->pluck('title', 'id');
        if(count($blocks) == 0) return redirect('admin/boxes')->with('error', 'Kreirajte provo šablon');
        $request->input('block_id')? $block_id = $request->input('block_id') : $block_id = null;
        return view('admin.boxes.create', compact('slug', 'block_id', 'blocks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBoxRequest $request)
    {
        $box = Box::create($request->except('image'));
        $box->publish = request('publish')?: 0;
        $box->update();

        $box->update(['image' => $box->storeImage()]);

        return redirect('admin/boxes')->with('done', 'Šablon je kreiran.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function show(Box $box)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function edit(Box $box)
    {
        $slug = 'blocks';
        $blocks = Block::where('publish', 1)->orderBy('title', 'ASC')->pluck('title', 'id');
        if(count($blocks) == 0) return redirect('admin/boxes')->with('error', 'Kreirajte provo šablon');
        return view('admin.boxes.edit', compact('slug', 'box', 'blocks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function update(CreateBoxRequest $request, Box $box)
    {

        $box->update($request->except('image'));
        $box->publish = request('publish')?: 0;
        $box->update();

        $box->update(['image' => $box->storeImage()]);
        return redirect('admin/boxes/'.$box->id.'/edit')->with('done', 'Šablon je izmenjen.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        //
    }

    public function delete($id)
    {
        $box = Box::find($id);
        File::delete($box->image);
        $box->delete();
        return redirect('admin/boxes')->with('done', 'Šablon je obrisan.');
    }

    public function publish(Request $request, $id){
        $val = $request->input('val');
        if($val == 'true'){ $publish = 1; }else{ $publish = 0; }
        $box = Box::find($id)->update(array('publish' => $publish));
        if(isset($box)){ return 'da'; }else{ return 'ne'; }
    }
}
