<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShoppingCart extends Model
{
    protected static $price = 0;
    protected static $total = 0;

    protected $fillable = ['customer_id', 'payment_id', 'coupon_id', 'price', 'tax', 'total', 'paid', 'paid_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(){
        parent::boot();

        static::addGlobalScope('customer', function (Builder $builder) {
            $builder->with('customer');
        });

        static::addGlobalScope('payment', function (Builder $builder) {
            $builder->with('payment');
        });

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->with('order');
        });
    }

    public static function store(){
        if(!empty(\Cart::content())){
            $shoppingCart = ShoppingCart::create([
                'customer_id' => 1,
                'payment_id' => 1,
            ]);
            foreach (\Cart::content() as $product){

                Order::create([
                    'shopping_cart_id' => $shoppingCart->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'total' => $product->total,
                    'qty' => $product->qty,
                    'size' => $product->options->has('size')? $product->options->size : null,
                    'color' => $product->options->has('color')? $product->options->color : null,
                ]);

                self::$price += $product->price;
                self::$total += $product->total;
            }
            $shoppingCart->update(['price' => self::$price, 'total' => self::$total]);
            \Cart::destroy();
            return true;
        }
        return false;
    }

    public function order(){
        return $this->hasMany(Order::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }
}
