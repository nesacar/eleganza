<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    protected $fillable = ['insta_shop_id', 'product_id', 'order', 'x', 'y', 'publish'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(){
        parent::boot();

        static::addGlobalScope('product', function (Builder $builder) {
            $builder->with('product');
        });
    }

    public function instaShop(){
        return $this->belongsTo(InstaShop::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
