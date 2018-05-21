<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Brand extends Model
{
    use Translatable;

    public static $list_limit = 50;

    protected $table = 'brands';

    public $translatedAttributes = ['title', 'slug', 'short', 'body', 'body2'];

    protected $fillable = ['id', 'order', 'logo', 'image', 'publish'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(){
        parent::boot();

        static::addGlobalScope('translations', function (Builder $builder) {
            $builder->with('translations');
        });
    }

    public function getTitle(){
        if(count($this->translations)>0){
            foreach ($this->translations as $translation){
                if($translation->locale == app()->getLocale()){
                    return $translation->title;
                }
            }
        }
        return 'title';
    }

    public function category(){
        return $this->hasMany(Category::class);
    }

    public function attribute(){
        return $this->belongsToMany(Attribute::class);
    }

    public function translations(){
        return $this->hasMany(BrandTranslation::class);
    }
}
