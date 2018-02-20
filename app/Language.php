<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public static $list_limit = 50;

    protected $table = 'languages';

    protected $fillable = ['name', 'fullname', 'locale', 'publish'];

    public static function setPrimary($language_id){
        $languages = Language::get();
        if(count($languages)>0){
            foreach ($languages as $language){
                if($language->id == $language_id){
                    $language->primary = 1;
                }else{
                    $language->primary = 0;
                }
                $language->update();
            }
        }
        return true;
    }
    
    public static function getPrimary(){
        return self::where('primary', 1)->first();
    }

    public function setting(){
        return $this->hasMany(Setting::class);
    }

    public function product(){
        return $this->hasMany(Product::class);
    }

    public function post(){
        return $this->hasMany(Post::class);
    }

    public function subscriber(){
        return $this->hasMany('App\Subscriber');
    }

    public function newsletter(){
        return $this->hasMany('App\Newsletter');
    }
}
