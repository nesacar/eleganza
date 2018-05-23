<?php

namespace App\Http\Controllers;

use App\Language;
use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
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
        $slug = 'settings';
        $settings = Setting::first();
        if(isset($settings)){
            return redirect('admin/settings/'.$settings->id.'/edit', compact('slug'));
        }else{
            return redirect('admin/settings/create', compact('slug'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'settings';
        $settings = Setting::first();
        if(count($settings)){
            return view('admin.settings.edit', compact('settings', 'slug'));
        }else{
            return view('admin.settings.create', compact('slug'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $setting = Setting::create($request->all());
        $request->input('blog')? $setting->blog = 1 : $setting->blog = 0;
        $request->input('shop')? $setting->shop = 1 : $setting->shop = 0;
        $request->input('colorDependence')? $setting->colorDependence = 1 : $setting->colorDependence = 0;
        $request->input('materialDependence')? $setting->materialDependence = 1 : $setting->materialDependence = 0;
        $request->input('newsletter')? $setting->newsletter = 1 : $setting->newsletter = 0;
        $setting->update();
        return redirect('admin/settings/'.$setting->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        $slug = 'settings';
        return view('admin.settings.edit', compact('setting', 'slug'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $setting->update($request->all());
        $request->input('blog')? $setting->blog = 1 : $setting->blog = 0;
        $request->input('shop')? $setting->shop = 1 : $setting->shop = 0;
        $request->input('colorDependence')? $setting->colorDependence = 1 : $setting->colorDependence = 0;
        $request->input('materialDependence')? $setting->materialDependence = 1 : $setting->materialDependence = 0;
        $request->input('newsletter')? $setting->newsletter = 1 : $setting->newsletter = 0;
        $setting->update();

        return redirect('admin/settings/'.$setting->id.'/edit')->with('done', 'Podešavanja su izmenjena.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
