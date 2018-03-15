<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CustomerRegisterRequest;
use App\Mail\RegisterConfirmationMail;
use App\Setting;
use App\Theme;
use App\User;
use Illuminate\Http\Request;

class RegistersController extends Controller
{
    public function login(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.login', compact('settings', 'theme'));
    }

    public function register(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.registration', compact('settings', 'theme'));
    }

    public function registerUpdate(CustomerRegisterRequest $request){
        $user = Customer::createCustomer();

        $theme = Theme::where('active', 1)->first();

        \Mail::to($user->email)->send(new RegisterConfirmationMail($user, $theme));

        return 'Strana hvala sto ste se registrovali. Na Vaš mail ce stici potvrdni link za registraciju.';
    }

    public function confirmRegistration($hash){
        $user = User::where('hash', $hash)->first();
        $user->active = 1;
        $user->update();
        auth()->loginUsingId($user->id);
        return redirect('profile');
    }
}
