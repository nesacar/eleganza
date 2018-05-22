<?php

namespace App;

use App\Traits\UploudableImageTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use UploudableImageTrait;

    public static $list_limit = 50;

    protected $table = 'brands';

    protected $fillable = ['id', 'title', 'slug', 'short', 'body', 'body2', 'order', 'logo', 'image', 'publish'];

    public function category(){
        return $this->hasMany(Category::class);
    }

    public function attribute(){
        return $this->belongsToMany(Attribute::class);
    }
}
