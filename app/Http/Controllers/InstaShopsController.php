<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInstaShopRequest;
use App\Http\Requests\UpdateInstaShopRequest;
use App\InstaShop;
use App\Product;
use Illuminate\Http\Request;
use File;

class InstaShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slug = 'blocks';
        $instaShops = InstaShop::orderBy('order', 'ASC')->paginate(50);
        return view('admin.instaShops.index', compact('slug', 'instaShops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'blocks';
        return view('admin.instaShops.create', compact('slug'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInstaShopRequest $request)
    {
        $instaShop = InstaShop::create(request()->all());
        $instaShop->storeImage();
        return view('admin.instaShops.edit', compact('slug', 'instaShop'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InstaShop  $instaShop
     * @return \Illuminate\Http\Response
     */
    public function show(InstaShop $instaShop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InstaShop  $instaShop
     * @return \Illuminate\Http\Response
     */
    public function edit(InstaShop $instaShop)
    {
        $slug = 'blocks';
        $productIds = Product::where('publish', 1)->pluck('code', 'id');
        return view('admin.instaShops.edit', compact('slug', 'instaShop', 'productIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InstaShop  $instaShop
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstaShopRequest $request, InstaShop $instaShop)
    {
        $instaShop->update(request()->all());
        $instaShop->featured = request('featured')?: false;
        $instaShop->publish = request('publish')?: false;
        $instaShop->update();

        $instaShop->storeImage();
        $instaShop->saveCoordinates();

        return redirect('admin/insta-shops/' . $instaShop->id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InstaShop  $instaShop
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstaShop $instaShop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InstaShop  $instaShop
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $instaShop = InstaShop::find($id);
        if($instaShop->image) File::delete($instaShop->image);
        $instaShop->delete();

        return redirect('admin/insta-shops');
    }

    public function coordinate(){
        $productIds = Product::where('publish', 1)->pluck('code', 'id');
        $x = request('x');
        $y = request('y');
        $pin = request('pin');
        return view('admin.instaShops._coordinate', compact('productIds', 'x', 'y', 'pin'));
    }
}
