<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Requests\CustomerRegisterRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Mail\ForgetPasswordMail;
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
        return view('themes.'.$theme->slug.'.pages.auth.login', compact('settings', 'theme'));
    }

    public function register(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.auth.registration', compact('settings', 'theme'));
    }

    public function registerUpdate(CustomerRegisterRequest $request){
        $user = Customer::createCustomer();
        $thm = Theme::where('active', 1)->first();
        \Mail::to($user->email)->send(new RegisterConfirmationMail($user, $thm));

        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $message = 'Hvala na registraciji';
        return view('themes.'.$theme->slug.'.pages.auth.thank-for-registration', compact('settings', 'theme', 'message'));
    }

    public function confirmRegistration($hash){
        $user = User::where('hash', $hash)->first();
        $user->active = 1;
        $user->update();
        auth()->loginUsingId($user->id);
        return redirect('profile');
    }

    public function passwordForgetForm(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.auth.forget-password', compact('settings', 'theme'));
    }

    public function passwordForgetUpdate(ForgetPasswordRequest $request){
        $user = User::where('email', request('email'))->first();
        if(!empty($user)){
            $settings = Setting::first();
            $theme = Theme::where('active', 1)->first();
            \Mail::to($user->email)->send(new ForgetPasswordMail($user, $theme));
            $message = 'Zaboravljena lozinka';
            return view('themes.'.$theme->slug.'.pages.auth.thank-for-registration', compact('settings', 'theme', 'user', 'message'));
        }else{
            return redirect('/');
        }
    }

    public function passwordNewUpdate(UpdatePasswordRequest $request, $hash){
        return 'slanje forme za reset';
        $user = User::where('hash', $hash)->first();
        if(!empty($user)){
            $user->password = bcrypt(request('password'));
            $user->update();
            return redirect('logovanje');
        }
        return redirect('/');
    }
}
