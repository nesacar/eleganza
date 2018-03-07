<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public static $list_limit = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'email', 'name', 'phone', 'message'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
