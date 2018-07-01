<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Coupon;
use App\Customer;
use App\Http\Requests\CustomerRegisterRequest;
use App\Http\Requests\EnterCouponRequest;
use App\Mail\OrderIsReadyMail;
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
        $theme = Theme::where('active', 1)->first();
        $settings = Setting::first();

        for($i=0;$i<count(request('ids'));$i++){
            $currentCart = \Cart::get(request('rowIds')[$i]);
            if(!empty($currentCart)){
                \Cart::update(request('rowIds')[$i], ['qty' => request('counts')[$i], 'options' => ['gift' => !empty(request('gift_' . request('ids')[$i]))? $settings->omot : 0]]);
            }
        }

        foreach (\Cart::content() as $product){
            if(session('discount')){
                $newPrice =  $product->price - ($product->price * session('discount') / 100) + $product->options->gift - ($product->options->gift * session('discount') / 100);
            }else{
                $newPrice =  $product->price + $product->options->gift;
            }
            \Cart::update($product->rowId, ['price' => $newPrice]);
        }

        $cart = \App\Cart::storeCart(auth()->user()->customer->id);
        Product::removeFromCart();

        $coupon = $cart->coupon? Coupon::where('code', $cart->coupon)->first() : new Coupon();

        session()->forget('coupon');
        session()->forget('discount');

        \Mail::to(auth()->user()->email)->send(new OrderIsReadyMail(auth()->user(), $theme, $cart, $coupon));
        \Mail::to(Setting::first()->email1)->send(new OrderIsReadyMail(auth()->user(), $theme, $cart, $coupon));

        return redirect('moje-narudzbine')->with('done', 'Vaša košarica je naručena');
    }

    public function coupon(Request $request){
        if($discount = Coupon::getDiscount(request('code'))){
            \Session::put('discount', $discount);
            \Session::put('coupon', request('code'));
            $coupon = Coupon::where('code', request('code'))->first();
            return response([
                'message' => 'done',
                'coupon' => $coupon,
            ]);
        }
        return 'error';
    }

    public function myOrders(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $carts = auth()->user()->customer->cart()->with('Product')->latest()->get();
        return view('themes.'.$theme->slug.'.pages.orders', compact('settings', 'theme', 'carts'));
    }

    public function myOrder($id){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $cart = Cart::with('Product')->with('Customer')->where('customer_id', auth()->user()->customer->id)->where('id', $id)->first();
        if(empty($cart)) return redirect('/profile');
        $coupon = $cart->coupon? Coupon::where('code', $cart->coupon)->first() : null;
        return view('themes.'.$theme->slug.'.pages.order', compact('settings', 'theme', 'cart', 'coupon'));
    }
}
