<?php

namespace App\Http\Controllers;

use App\Banner;
use App\BannerTranslation;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\EditAdminSusbcribersRequest;
use App\Http\Requests\EditBannerLangRequest;
use App\Http\Requests\EditBannerRequest;
use App\Language;
use App\Subscriber;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Input;
use File;

class BannersController extends Controller
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
        $slug = 'newsletters';
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $banners = Banner::orderBy('created_at', 'DESC')->paginate(50);
        return view('admin.banners.index', compact('slug', 'banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'newsletters';
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $languages = Language::where('publish', 1)->orderBy('order', 'ASC')->pluck('name', 'id')->prepend('Svi jezici', 0);
        return view('admin.banners.create', compact('slug', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBannerRequest $request)
    {
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $banner = Banner::create($request->all());
        $banner->title = $request->input('title');
        $banner->link = $request->input('link');

        if($request->hasFile('image')){
            $imageName = 'hr-' . $banner->id . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = 'images/banners/'.$imageName;
            $request->file('image')->move(base_path() . '/public/images/banners/', $imageName);
            $banner->image = $imagePath;
        }

        $request->input('publish')? $banner->publish = 1 : $banner->publish = 0;
        $banner->update();
        return redirect('admin/banners')->with('done', 'Baner je kreiran');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slug = 'newsletters';
        $banner = Banner::find($id);
        $languages = Language::where('publish', 1)->orderBy('order', 'ASC')->get();
        return view('admin.banners.edit', compact('slug', 'banner', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(EditBannerRequest $request, $id)
    {
        $banner = Banner::find($id);
        $banner->update($request->all());
        $request->input('publish')? $banner->publish = 1 : $banner->publish = 0;
        $banner->update();

        return redirect('admin/banners')->with('save', 'Baner je izmenjen');
    }

    public function updateLang(EditBannerLangRequest $request, $id){
        $primary = Language::getPrimary();
        $request->input('locale')? $locale = $request->input('locale') : $locale = $primary->locale;
        app()->setLocale($locale);
        $banner = Banner::find($id);
        $banner->title = $request->input('title');
        $banner->link = $request->input('link');

        if($request->hasFile('image')){
            $imageName = $locale . '-' . $banner->id . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = 'images/banners/'.$imageName;
            $request->file('image')->move(base_path() . '/public/images/banners/', $imageName);
            $banner->image = $imagePath;
        }

        $banner->update();

        return redirect()->back()->with('done', 'Baner je izmenjen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id){
        $banner = Banner::find($id);
        $translations = BannerTranslation::where('banner_id', $banner->id)->get();
        foreach ($translations as $translation){
            if($translation->image != null){
                File::delete($translation->image);
            }
        }
        if(isset($banner)){
            File::delete($banner->image);
            $banner->delete();
        }
        return redirect('admin/banners')->with('save', 'Banner je obrisan');
    }

    public function deleteimg($id, $locale){
        $banner = BannerTranslation::where('banner_id', $id)->where('locale', $locale)->first();
        File::delete($banner->image);
        $banner->image = null;
        $banner->update();
        return view('admin.banners.image_append');
    }

    public function publish($id){
        $val = Input::get('val');
        if($val == 'true'){ $primary = 1; }else{ $primary = 0; }
        $banner = Banner::find($id)->update(array('publish' => $primary));
        if(isset($banner)){ return 'da'; }else{ return 'ne'; }
    }
}
