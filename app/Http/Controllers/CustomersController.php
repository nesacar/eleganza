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
        //return request()->all();

        for($i=0;$i<count(request('ids'));$i++){
            $currentCart = \Cart::get(request('rowIds')[$i]);
            \Cart::update(request('rowIds')[$i], ['price' => (float) $currentCart->price * request('counts')[$i]]);
        }

        $sum = \Cart::total();
        $omot = Cart::omot(16.41);
        if(\Session::has('discount')){
            $discount = \Session::get('discount');
            $discount = ($discount / 100) * $sum;
            $sum = $sum - $discount;
        }else{
            $discount = 0;
        }
        \App\Cart::storeCart(auth()->user()->customer->id, (float) $sum + $omot, 0, $discount);
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

    public function myOrders(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $carts = auth()->user()->customer->cart()->with('Product')->get();
        return view('themes.'.$theme->slug.'.pages.orders', compact('settings', 'theme', 'carts'));
    }

    public function myOrder($id){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $cart = Cart::with('Product')->with('Customer')->where('customer_id', auth()->user()->customer->id)->where('id', $id)->first();
        if(empty($cart)) return redirect('/profile');
        return view('themes.'.$theme->slug.'.pages.order', compact('settings', 'theme', 'cart'));
    }
}
