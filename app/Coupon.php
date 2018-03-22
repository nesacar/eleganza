<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public static $list_limit = 50;

    protected $table = 'coupons';

    protected $fillable = ['code', 'discount', 'number', 'publish_at', 'valid_at', 'publish', 'forever'];

    public static function getDiscount($code){
        $coupon = self::where('code', $code)->where('publish_at', '<=', Carbon::now())->where('valid_at', '>=', Carbon::now())->where('number', '>', 0)->first();
        if(!empty($coupon)){
            $coupon->decrement('number');
            return $coupon->discount;
        }else{
            return false;
        }
    }
}
