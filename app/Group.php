<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = ['id', 'title', 'order', 'publish'];

    public function product(){
        return $this->belongsToMany(Product::class);
    }
}