<?php namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Attribute extends Model {

    use Translatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attributes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $translatedAttributes = ['title'];

    protected $fillable = ['id', 'property_id', 'extra', 'order', 'publish'];

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

    public static function checkFilter($osobina_id, $category_id){
        $res = array();
        $osobina = Property::find($osobina_id);
        $category = PCategory::find($category_id);
        foreach($osobina->attribute as $atr){
            foreach($category->attribute as $catr){
                if($atr == $catr){
                    $res = array_add($atr);
                }
            }
        }
        return $res;
    }

    public static function save_att_order($niz){
        $i=-1;
        foreach($niz as $n){
            $i++;
            if($i>0){
                if($n['parent_id'] == null){
                    Attribute::save_order($n['item_id'], $i, false, $n['depth']);
                }else{
                    Attribute::save_order($n['item_id'], $i, $n['parent_id'], $n['depth']);
                }
            }
        }
    }

    public static function getSortAttribute($oso = false){
        if($oso){
            $osobina = Property::find($oso);
            $attributes = $osobina->attribute()->where(array('publish' => 1))->orderby('order', 'ASC')->get();
        }
        $str="";
        if(count($attributes) > 0){
            $str .=  "<ol class='sortable'>";
            foreach($attributes as $a){
                $str .= "<li id='list_{$a->id}'><div>".$a->title."</div>";
                $str .= Property::getSortOsobina($a->id);
                $str .= "</li>";
            }
            $str .= "</ol>";
        }
        return $str;
    }

    public static function save_order($id, $poz, $parent = false, $depth){
        if($parent){
            Attribute::findOrFail($id)->update(array('order' => $poz, 'parent' => $parent, 'level' => $depth));
        }else{
            Attribute::findOrFail($id)->update(array('order' => $poz, 'parent' => 0, 'level' => $depth));
        }
    }

    public static function getMaterialsList(){
        return Attribute::leftJoin('osobinas', 'attributes.osobina_id', '=', 'osobinas.id')
            ->leftJoin('attribute_translations', 'attributes.id', '=', 'attribute_id')
            ->where('osobinas.id', 14)->where('attribute_translations.locale', app()->getLocale())
            ->pluck('attribute_translations.title', 'attribute_translations.attribute_id')
            ->prepend(trans('language.Select material'), 0)->toArray();
    }

    public static function getMaterialListByProduct($product_id){
        return Attribute::leftJoin('osobinas', 'attributes.osobina_id', '=', 'osobinas.id')
            ->leftJoin('attribute_translations', 'attributes.id', '=', 'attribute_id')
            ->leftJoin('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
            ->leftJoin('products', 'attribute_product.product_id', '=', 'products.id')
            ->where('osobinas.id', 14)->where('attribute_translations.locale', app()->getLocale())->where('products.id', $product_id)
            ->pluck('attribute_translations.title', 'attribute_translations.attribute_id')
            ->prepend(trans('language.Select material'), 0)->toArray();
    }

    public static function getFilteredAttributes($property_id, $category_id){
        return self::select('attributes.*')->join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
            ->join('products', 'attribute_product.product_id', '=', 'products.id')
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->where('attributes.property_id', $property_id)->where('category_product.category_id', $category_id)
            ->where('attributes.publish', 1)->groupBy('attributes.id')->orderBy('attributes.order', 'ASC')->get();
    }

    public static function prepareAttributeFromVueExcelTable($att1, $att2, $att3, $att4, $att5, $att6, $att7, $att8){
        $array = array();
        if(!empty($att1) && $att1 != 0) $array[] = $att1;
        if(!empty($att2) && $att2 != 0) $array[] = $att2;
        if(!empty($att3) && $att3 != 0) $array[] = $att3;
        if(!empty($att4) && $att4 != 0) $array[] = $att4;
        if(!empty($att5) && $att5 != 0) $array[] = $att5;
        if(!empty($att6) && $att6 != 0) $array[] = $att6;
        if(!empty($att7) && $att7 != 0) $array[] = $att7;
        if(!empty($att8) && $att8 != 0) $array[] = $att8;
        return $array;
    }

    public static function getAttributesByProduct($product_id){
        return self::select('attribute_translations.title', 'property_translations.title as property')->join('attribute_translations', 'attributes.id', '=', 'attribute_translations.attribute_id')
            ->join('properties', 'attributes.property_id', '=', 'properties.id')->join('property_translations', 'properties.id', '=', 'property_translations.property_id')
            ->join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
            ->where('attribute_product.product_id', $product_id)->where('properties.publish', 1)->where('attributes.publish', 1)->groupBy('attributes.id')->get();
    }

    public function property(){
        return $this->belongsTo('App\Property');
    }

    public function product(){
        //return $this->belongsToMany('App\Product')->withPivot('price');
        return $this->belongsToMany('App\Product');
    }

    public function menuLink(){
        return $this->belongsToMany(MenuLink::class);
    }

    public function brand(){
        return $this->belongsToMany(Brand::class);
    }

    public function set(){
        return $this->belongsToMany('App\Set');
    }

    public function translations(){
        return $this->hasMany(AttributeTranslation::class);
    }
}
