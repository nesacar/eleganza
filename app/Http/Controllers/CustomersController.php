<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Theme;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function __construct() {
        $this->middleware('customer');
    }

    public function profile(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.profile', compact('settings', 'theme'));
    }
}
