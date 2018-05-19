<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use File;

class InstaShop extends Model
{
    protected $fillable = ['title', 'image', 'desc', 'order', 'publish'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(){
        parent::boot();

        static::addGlobalScope('coordinate', function (Builder $builder) {
            $builder->with('coordinate');
        });
    }

    public function storeImage(){
        if($image = request()->file('image')){
            $file_path = 'storage/' . $image->storeAs(
                'insta-shops/',
                str_slug($this->title) . '-' . $this->id . '.' . $image->getClientOriginalExtension(),
                'public'
                );
            $this->update(['image' => $file_path]);
        }
    }

    public function saveCoordinates(){
        if(count($this->coordinate)>0){
            foreach ($this->coordinate as $coordinate){
                $coordinate->delete();
            }
        }

        if(request()->has('products')){
            for($i=0;$i<count(request('products'));$i++){
                Coordinate::create([
                    'insta_shop_id' => $this->id,
                    'product_id' => request('products')[$i],
                    'x' => request('x')[$i],
                    'y' => request('y')[$i],
                    'order' => $i,
                    'publish' => 1,
                ]);
            }
        }
    }

    public function coordinate(){
        return $this->hasMany(Coordinate::class);
    }
}
