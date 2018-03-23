<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Coupon;
use App\Customer;
use App\Http\Requests\CustomerRegisterRequest;
use App\Http\Requests\EnterCouponRequest;
use App\Product;
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

    public function cartUpdate(Request $request){
        $sum = Product::whereIn('id', request('ids'))->sum('price_outlet');
        $omot = Cart::omot(16.41);
        if(\Session::has('discount')){
            $discount = \Session::get('discount');
            $discount = ($discount / 100) * $sum;
            $sum = $sum - $discount;
        }else{
            $discount = 0;
        }
        Cart::storeCart(auth()->user()->customer->id, $sum + $omot, 0, $discount);
        Product::removeFromCart();
        return redirect('profile')->with('done', 'Vaša košarica je naručena');
    }

    public function coupon(Request $request){
        if($discount = Coupon::getDiscount(request('code'))){
            \Session::put('discount', $discount);
            \Session::put('coupon', request('code'));
            return 'done';
        }
        return 'error';
    }
}
