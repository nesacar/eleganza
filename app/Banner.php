<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

    protected $table = 'banners';

    protected $fillable = ['title', 'link', 'image', 'width', 'height', 'publish'];

    public static function getBannerSelect($locale='sr'){
        return self::join('banner_translations', 'banners.id', '=', 'banner_translations.banner_id')
            ->where('banner_translations.locale', $locale)->where('banners.publish', 1)
            ->pluck('banner_translations.title', 'banners.id');
    }

    public function newsletter(){
        return $this->belongsToMany(Newsletter::class);
    }

    public function language(){
        return $this->belongsTo(Language::class);
    }
}
