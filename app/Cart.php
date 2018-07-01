<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cart extends Model {

    public static $minutes = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id', 'payment_id', 'sum', 'status', 'delivery', 'discount', 'coupon'];

    public static function cartSum($id){
        $cart = Cart::find($id);
        $sum = 0;
        foreach($cart->product as $p){
            $sum += $p->pivot->price;
        }
        return $sum;
    }

    public static function status($id){
        $str='';
        if($id == 0){
            $str = 'na &#269;ekanju';
        }elseif($id == 1){
            $str = 'potv&#273;eno';
        }elseif($id == 2){
            $str = 'odbijeno';
        }elseif($id == 3){
            $str = 'otkazano';
        }
        return $str;
    }

    public static function boja($id){
        $str='';
        if($id == 0){
            $str = 'plava';
        }elseif($id == 1){
            $str = 'zelena';
        }elseif($id == 2){
            $str = 'crvenoj';
        }elseif($id == 3){
            $str = 'narandzasta';
        }
        return $str;
    }

    public static function bojaHDEX($id){
        $str='';
        if($id == 0){
            $str = '#00688B';
        }elseif($id == 1){
            $str = '#84d084';
        }elseif($id == 2){
            $str = '#ca0002';
        }elseif($id == 3){
            $str = '#ffb347';
        }
        return $str;
    }

    public static function getProductCount($cart_id, $product_id){
        $pr = DB::table('cart_product')->where('cart_id', $cart_id)->where('product_id', $product_id)->get();
        return count($pr);
    }

    public static function getProductPrice($cart_id, $product_id){
        $cart = self::find($cart_id);
        return $cart->product()->where('id', $product_id)->first()->pivot->price * self::getProductCount($cart_id, $product_id);
    }

    public static function filteredCarts($s, $od, $do, $datod, $datdo){
        return self::select('carts.*', 'customers.email as email')
            ->join('customers', 'carts.customer_id', '=', 'customers.id')
            ->where(function($query) use ($s){
                if(!empty($s)){
                    $query->where('customers.email', 'LIKE', "%$s%");
                }
            })->where(function($query) use ($od, $do){
                if(!empty($od)){
                    $query->where('carts.sum', '>=', $od);
                }
                if(!empty($do)){
                    $query->where('carts.sum', '<=', $do);
                }
            })->where(function($query) use ($datod, $datdo){
                if(!empty($datod)){
                    $query->where('carts.created_at', '>=', $datod);
                }
                if(!empty($datdo)){
                    $query->where('carts.created_at', '<=', $datdo);
                }
            })->groupBy('carts.id')->orderBy('carts.created_at', 'DESC')->paginate(50);
    }

    public static function addToSession($id, $q, $s, $c, $m){
        $korpa = array(); $qty = array(); $size = array(); $color = array(); $material = array();
        if(\Session::has('korpa')){ //id
            $korpa = \Session::pull('korpa');
        }
        if(\Session::has('qty')){ //id
            $qty = \Session::pull('qty');
        }
        if(\Session::has('size')){ //id
            $size = \Session::pull('size');
        }
        if(\Session::has('color')){ //id
            $color = \Session::pull('color');
        }
        if(\Session::has('material')){ //id
            $material = \Session::pull('material');
        }
        if(isset($id)){
            $korpa[] = $id;
            $qty[] = $q;
            $size[] = $s;
            $color[] = $c;
            $material[] = $m;
        }
        $korpa = array_unique($korpa);
        \Session::put('korpa', $korpa); \Session::put('qty', $qty); \Session::put('size', $size); \Session::put('color', $color); \Session::put('material', $material);
    }

    public static function storeCart($user){
        $cart = new Cart();
        $cart->customer_id = $user;
        $cart->country_id = 1;
        $cart->sum = \Cart::total();
        $cart->status = 0;
        $cart->payment_id = 1;
        $cart->discount = \Session::has('discount')? \Session::get('discount') : null;
        $cart->coupon = \Session::has('coupon')? \Session::get('coupon') : null;
        $cart->delivery = request('delivery')? 1 : 0;
        $cart->save();

        foreach (\Cart::content() as $product){
            if($product->options->gift > 0){
                $cart->product()->attach($product->id, ['omot' => 1, 'price' => $product->price, 'count' => $product->qty]);
            }else{
                $cart->product()->attach($product->id, ['omot' => 0, 'price' => $product->price, 'count' => $product->qty]);
            }
        }

        \Session::forget('discount');
        \Session::forget('coupon');

        return $cart;
    }

    public static function checkFilterNav($niz, $cat=false, $id=false){
        $res=false;
        if(\Session::has('filter')){
            if($id && $cat){
                if(in_array($id, \Session::get('filter'))){
                    $res=true;
                }
            }else{
                if(count($niz)){
                    foreach($niz as $n){
                        if(in_array($n->id, \Session::get('filter'))){
                            $res=true;
                        }
                    }
                }
            }
        }
        return $res;
    }

    public static function sendEmailCart($cart_id){
        $cart = self::find($cart_id);
        $user = User::find($cart->user_id);
        $settings = Settings::find(1);

        $to      = $user->email;
        $subject = 'Obaveštenje o porudžbini | pggrupa.rs';
        $message = self::makeEmailCart($cart->id, 1); // zahvalnica
        $headers = 'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=UTF-8' . "\r\n" .
            'From: office@pggrupa.rs' . "\r\n" .
            'Reply-To: office@pggrupa.rs' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        $to      = $settings->email1;
        $subject = 'Zahtev za porudžbinu | pggrupa.rs';
        $message = self::makeEmailCart($cart->id); // Zahtev za porudžbinu
        $headers = 'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=UTF-8' . "\r\n" .
            'From: office@pggrupa.rs' . "\r\n" .
            'Reply-To: office@pggrupa.rs' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    public static function sendDummyMail($cart_id){
        $cart = self::find($cart_id);
        $user = User::find($cart->user_id);

        $to      = $user->email;
        $subject = 'Nova porudžbina na sajtu pggrupa.rs';
        $message = 'Uspešno ste izvrvšili porudžbinu na sajtu PGGrupa.rs. Očekujte uskoro poziv operatera.';
        $headers = 'From: info@pggrupa.rs' . "\r\n" .
            'Reply-To: info@pggrupa.rs' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    public static function checkFilters($niz, $id=false){
        $res=false;
        if($id){
            if(in_array($id, $niz)){
                $res=true;
            }
        }else{
            if(count($niz)){
                foreach($niz as $n){
                    if(in_array($n->id, $niz)){
                        $res=true;
                    }
                }
            }
        }
        return $res;
    }

    public static function getMaterialTitle($cart_id, $product_id){
        $material = DB::table('cart_product')->where('cart_id', $cart_id)->where('product_id', $product_id)->first();
        if(isset($material) && $material->material != 0){
            $att = Attribute::find($material->material);
            return $att->{'title:sr'};
        }else{
            return '';
        }
    }

    public static function omot($price){
        $sum = 0;
        if(count(request('ids'))>0){
            for ($i=0;$i<count(request('ids'));$i++){
                if(!empty(request('gift_'.request('ids')[$i]))){
                    $sum += $price * request('counts')[$i];
                }
            }
        }
        return $sum;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function product(){
        return $this->belongsToMany('App\Product')->withPivot('count', 'omot', 'color', 'size', 'price');
    }

    public function customer(){
        return $this->belongsTo('App\Customer');
    }
}
