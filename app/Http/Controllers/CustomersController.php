<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CustomerRegisterRequest;
use App\Setting;
use App\Theme;
use App\User;
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
