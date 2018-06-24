<?php namespace App;

use App\Traits\SearchableProductTraits;
use App\Traits\UploudableImageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Str;
use File;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class Product extends Model {

    use UploudableImageTrait, SearchableProductTraits;

    public static $list_limit = 50;
    public static $paginate = 12;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['brand_id', 'user_id', 'set_id', 'title', 'slug', 'short', 'body', 'body2', 'code', 'image', 'price_small', 'price_outlet', 'diameter', 'water', 'views', 'amount', 'color', 'featured', 'discount', 'sold', 'publish_at', 'publish'];

    protected static $searchable = ['filters', 'minPrice', 'maxPrice', 'minWater', 'maxWater', 'minPromer', 'MaxPromer'];

    protected $appends = ['fullImagePath', 'link', 'tmb'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(){
        parent::boot();

        static::addGlobalScope('category', function (Builder $builder) {
            $builder->with(['category' => function($query){
                $query->where('publish', 1)->orderBy('parent', 'ASC');
            }]);
        });

        static::addGlobalScope('brand', function (Builder $builder) {
            $builder->with(['brand' => function($query){
                $query->where('publish', 1)->orderBy('order', 'ASC');
            }]);
        });

        static::addGlobalScope('attribute', function (Builder $builder) {
            $builder->with(['attribute' => function($query){
                $query->where('publish', 1)->orderBy('order', 'ASC');
            }]);
        });
    }

    public function getLink($category = false){
        if($category){
            return url($category->getLink() .  $this->slug . '/' . $this->id);
        }else{
            $str = 'shop/';
            if(count($this->category)>0){
                foreach ($this->category as $category){
                    $str .= $category->slug . '/';
                }
            }
            $str .= $this->slug . '/' . $this->id;
            return url($str);
        }
    }

    public function getBreadcrumb($slug){
        $str = '<nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="'. url('/') . '">Home</a></li>';
        $level = -1;
        if(count($this->category)>0){
            foreach ($this->category as $category){
                if(($level == -1 && $category->slug == $slug) || $level != -1){
                    if($level != $category->level){
                        $level = $category->level;
                        $str .= '<li class="breadcrumb-item"><a href="' . $category->getLink() . '">' . $category->title . '</a></li>';
                    }
                }
            }
        }

        $str .= '<li class="breadcrumb-item active" aria-current="page">' . $this->title . '</li></ol></nav>';

        return $str;
    }

    public function getLinkAttribute(){
        return $this->getLink();
    }

    public function getTmbAttribute(){
        return url(\Imagecache::get($this->image, '50x73')->src);
    }

    public static function getAtt($product_id, $category_id){
        $category = PCategory::find($category_id);

        $pr = Product::find($product_id)->attribute()->pluck('id')->toArray();
        $str="";
        $attributes = Attribute::where('publish', 1)->pluck('id')->toArray();
        if(count($category->osobina) > 0){
            $str .=  "<ul>";
            foreach($category->osobina as $o){
                $str .=  "<li>".$o->{'title:hr'}."</li>";
                if($o->attribute){
                    $str .=  "<ul>";
                    foreach($o->attribute as $a){
                        if(in_array($a->id, $attributes)){
                            if(in_array($a->id, $pr)){
                                $price = Attribute::where('id', $a->id)->first()->product()->where('id', $product_id)->first()->pivot->price;
                                $str .= "<li><input type='checkbox' name='filter[]' value='{$a->id}' checked > <span>".$a->{'title:hr'}."</span> <input type='text' name='price[]' value='{$price}'></li>";
                            }else{
                                $str .= "<li><input type='checkbox' name='filter[]' value='{$a->id}' > <span>".$a->{'title:hr'}."</span></li>";
                            }
                        }
                    }
                    $str .= "</ul>";
                }
            }
            $str .= "</ul>";
        }else{
            $osobinas = Property::where('publish', 1)->get();
            if(isset($osobinas)){
                $str .=  "<ul>";
                foreach($osobinas as $o){
                    $str .=  "<li>".$o->{'title:hr'}."</li>";
                    if($o->attribute){
                        $str .=  "<ul>";
                        foreach($o->attribute as $a){
                            if(in_array($a->id, $attributes)) {
                                if (in_array($a->id, $pr)) {
                                    $price = Attribute::where('id', $a->id)->first()->product()->where('id', $product_id)->first()->pivot->price;
                                    $str .= "<li><input type='checkbox' name='filter[]' value='{$a->id}'> <span>" . $a->{'title:hr'} . "</span> <input type='text' name='price[]' value='{$price}'></li>";
                                } else {
                                    $str .= "<li><input type='checkbox' name='filter[]' value='{$a->id}' > <span>" . $a->{'title:hr'} . "</span></li>";
                                }
                            }
                        }
                        $str .= "</ul>";
                    }
                }
                $str .= "</ul>";
            }
        }
        return $str;
    }

    /*public static function filtriraj($products, $cat, $br){
        $res = array();
        if($cat){
            foreach($products as $p){
                if($p->broj == $br){
                    $res[] = $p;
                }
            }
        }else{
            foreach($products as $p) {
                $count = Product::find($p->id)->category()->count();
                if($br == $p->broj/$count){
                    $res[] = $p;
                }
            }
        }
        return $res;
    }*/

    public static function getLastCategory($id){
        $product = self::find($id);
        if(isset($product) && count($product->category) > 0){
            $br=0;
            $cat = self::find($product->category->first()->id);
            foreach($product->category as $c){
                if($c->level > $br){
                    $br = $c->level;
                    $cat = $c;
                }
            }
            return $cat->{'title:hr'};
        }else{
            return null;
        }
    }

    public static function getBrend($id){
        $product = self::find($id); $cat = false;
        if(isset($product) && count($product->category) > 0){
            foreach($product->category as $c){
                if($c->level == 2){
                    $cat = $c;
                }
            }
            if($cat){
                return $cat->title;
            }else{
                return 'nema brenda';
            }
        }else{
            return null;
        }
    }

    public static function getBrendObject($id){
        $product = self::find($id); $cat = false;
        if(isset($product) && count($product->category) > 0){
            foreach($product->category as $c){
                if($c->level == 2){
                    $cat = $c;
                }
            }
            if($cat){
                return $cat;
            }else{
                return 'nema brenda';
            }
        }else{
            return null;
        }
    }

    public static function getLastCategoryObject($id){
        $product = self::find($id);
        if(isset($product) && count($product->category) > 0){
            $br=0;
            $cat = $product->category->first();
            foreach($product->category as $c){
                if($c->level > $br){
                    $br = $c->level;
                    $cat = $c;
                }
            }
            return $cat;
        }else{
            return null;
        }
    }

    public static function getProductLink($id, $locale=false){
        $product = self::find($id);
        if(count($product->category) > 0){
            $cat = self::getLastCategoryObject($product->id);
            if($locale){
                $link = Category::getShopLink($cat->id, $locale).$product->{'slug:'.$locale}.'/'.$product->id;
            }else{
                $link = Category::getShopLink($cat->id).$product->slug.'/'.$product->id;
            }
        }else{
            $link = '';
        }
        return 'shop/'.$link;
    }

    public static function getRelatedByCategory($cat_id, $product_id, $num){
        return Category::find($cat_id)->product()->where('products.id', '<>', $product_id)->orderByRaw("RAND()")->take($num)->get();
    }

//    public static function getRelatedByColor($product){
//        $ids = Attribute::join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')->where('attribute_product.product_id', $product->id)
//            ->where('attributes.extra', null)->pluck('attributes.id');
////        $products = self::join('attribute_product', 'products.id', '=', 'attribute_product.product_id')
////            ->where(function($query) use ($ids){
////                if(count($ids)>0){
////                    foreach($ids as $id){
////                        $query->where('attribute_product.attribute_id', $id);
////                    }
////                }
////            })->orderBy('products.publish_at', 'DESC')->toSql();
//
//        $products = self::whereIn('products.id', function ($query) use ($ids){
//            foreach ($ids as $id){
//                $query->select('attribute_product.product_id')->from('attribute_product.attribute_product')->where('attribute_product.attribute_id', $id);
//            }
//        })->orderBy('products.publish_at', 'DESC')->get();
//
//        dd($products);
//    }

    public static function productInSession($id){
        $status = false;
        if(\Session::has('korpa') && is_array(\Session::get('korpa'))){
            foreach(\Session::get('korpa') as $pr){
                if($pr == $id){
                    $status = true;
                }
            }
        }
        return $status;
    }

    public static function setSlug($id){
        $product = self::find($id);
        if(Product::where('slug', $product->slug)->where('id', '<>', $product->id)->first()){
            $url = $product->slug.'-'.str_random(1);
            if(Product::where('slug', $url)->where('id', '<>', $product->id)->first()){
                self::setSlug($product->id);
            }
            $product->slug = $url;
            $product->update();
        }
    }

    public static function getFiltersByCategory($cat, $locale='hr'){
        return Attribute::select('attributes.id')
            ->join('attribute_translations', 'attributes.id', '=', 'attribute_translations.attribute_id')
            ->join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
            ->join('products', 'attribute_product.product_id', '=', 'products.id')
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->where('category_product.category_id', $cat)->where('products.publish', 1)
            ->where('attributes.publish', 1)->where('attribute_translations.locale', $locale)
            ->groupBy('attributes.id')->orderBy('order', 'attributes.order')->pluck('attributes.id')->toArray();
    }

    public static function getManProductCount(){
        return self::select('products.id')
            ->join('attribute_product', 'products.id', '=', 'attribute_product.product_id')
            ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
            ->where('products.publish', 1)->where('attributes.id', 262)->count();
    }

    public static function getWomanProductCount(){
        $w = Attribute::where('publish', 1)->where('title', 'ženski')->first();
        return self::select('products.id')
            ->join('attribute_product', 'products.id', '=', 'attribute_product.product_id')
            ->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
            ->where('products.publish', 1)->where('attributes.id', 263)->count();
    }

    public static function getMaxPrice($products=false){
        $max=0;
        if($products){
            if(count($products) > 0){
                foreach($products as $p){
                    if($p->price_small > $max){
                        $max = $p->price_small;
                    }
                }
            }
        }else{
            $product = self::where('publish', 1)->orderby('price_small', 'DESC')->first();
            $max = $product->price_small;
        }
        return $max;
    }

    public static function filter($products, $cat, $br , $page=0, $limit=1){
        $res = array(); $fin = array();
        if($cat){
            foreach($products as $p){
                if($p->broj == $br){
                    $res[] = $p;
                }
            }
        }else{
            foreach($products as $p) {
                $count = Product::find($p->id)->category()->count();
                if($br == $p->broj/$count){
                    $res[] = $p;
                }
            }
        }
        $page = ($page-1)*$limit;
        $num = ceil(count($res)/$limit);
        $br = count($res);
        $res = array_slice($res, $page, $limit);
        $fin[0] = $res; $fin[1] = $num; $fin[2] = $br;
        return $fin;
    }

    public static function getRelatedProducts($product, $category, $limit=4){
        $relation = Relation::where('product_id', $product->id)->first();
        $related = [];
        if(isset($relation)){

            if(count($relation->product)){
                $rel = $relation->product()->where('id', '<>', $product->id)->orderByRaw("RAND()")->take($limit)->get(); //related products (max 4)

                if(count($rel)){ foreach($rel as $r){ $related[] = $r; } }

                if(count($related) < $limit){
                    if(count($relation->category)>0){
                        $cat_br = count($relation->category);
                        $br = $limit - count($related);
                        $per_cat = ceil($br/$cat_br);
                        foreach($relation->category as $cat){
                            $temp = array();
                            $rel = $cat->product()->where('id', '<>', $product->id)->where(function ($q) use ($related){
                                foreach($related as $r){
                                    $q->where('id', '<>', $r->id)->get();
                                }
                            })->orderByRaw("RAND()")->take($per_cat)->get(); //related categories
                            if(count($rel)){ foreach($rel as $r){ $temp[] = $r; } }
                        }
                        if(count($temp)>0){
                            //$temp = shuffle($temp);
                            foreach($temp as $t){
                                $related[] = $t;
                            }
                        }
                    }
                    if(count($related) < $limit){
                        $rel = $category->product()->where('id', '<>', $product->id)->where(function ($q) use ($related){
                            foreach($related as $r){
                                $q->where('id', '<>', $r->id)->get();
                            }
                        })->orderByRaw("RAND()")->take($limit - count($related))->get();
                        if(count($rel)){ foreach($rel as $r){ $related[] = $r; } }
                    }
                }
            }
            if(count($related)==0){ $related = $category->product()->where('id', '<>', $product->id)->orderByRaw("RAND()")->take(4)->get(); }
        }else{
            $related = $category->product()->where('id', '<>', $product->id)->orderByRaw("RAND()")->take(4)->get();
        }
        return $related;
    }

    public static function getSizes($product){
        $sizes = Property::where('title', 'Size')->first()->attribute()->pluck('id')->toArray();
        $pr = $product->attribute()->pluck('title', 'id');
        $res = array();
        if(count($pr) > 0){
            foreach($pr as $key => $p){
                if(count($sizes) > 0){
                    if(in_array($key, $sizes)){
                        $res[$key] = $p;
                    }
                }
            }
        }
        return $res;
    }

    public static function getMaterial($product){
        $sizes = Property::where('id', 14)->first()->attribute()->pluck('id')->toArray();
        $pr = $product->attribute()->pluck('id');
        $res = array();
        if(count($pr) > 0){
            foreach($pr as $p){
                if(count($sizes) > 0){
                    if(in_array($p, $sizes)){
                        $res[] = $p;
                    }
                }
            }
        }
        return $res;
    }

    public static function newMaxPrice($cat=0, $fil, $min=0, $max=0){
        if($cat == 0){
            return Product::select('products.*')
                ->join('attribute_product','products.id','=','attribute_product.product_id')
                ->join('attributes','attribute_product.attribute_id','=','attributes.id')
                ->where('products.publish', 1)
                ->where(function($query) use ($fil)
                {
                    if(count($fil) > 0){
                        $query->whereIn('attributes.id', $fil);
                    }
                })
                ->where(function($query) use ($min, $max)
                {
                    if($max > 0){
                        $query->whereBetween('products.price_small', [$min, $max]);
                    }
                })
                ->orderBy('products.price_small', 'DESC')
                ->groupBy('products.id')
                ->first();
        }else{
            return Product::select('products.*')
                ->join('category_product', 'products.id', '=', 'category_product.product_id')
                ->join('categories', 'category_product.category_id', '=', 'categories.id')
                ->join('attribute_product','products.id','=','attribute_product.product_id')
                ->join('attributes','attribute_product.attribute_id','=','attributes.id')
                ->where('categories.id', $cat)
                ->where('products.publish', 1)
                ->where(function($query) use ($fil)
                {
                    if(count($fil) > 0){
                        $query->whereIn('attributes.id', $fil);
                    }
                })
                ->where(function($query) use ($min, $max)
                {
                    if($max > 0){
                        $query->whereBetween('products.price_small', [$min, $max]);
                    }
                })
                ->orderBy('products.price_small', 'DESC')
                ->groupBy('products.id')
                ->first();
        }
    }

    public static function getFeaturedProducts($cat){
        $home = PCategory::find($cat);
        $featured = array();
        if($home->p1 != 0){
            $pr = Product::find($home->p1);
            $featured[] = $pr;
        }
        if($home->p2 != 0){
            $pr = Product::find($home->p2);
            $featured[] = $pr;
        }
        if($home->p3 != 0){
            $pr = Product::find($home->p3);
            $featured[] = $pr;
        }
        if($home->p4 != 0){
            $pr = Product::find($home->p4);
            $featured[] = $pr;
        }
        if($home->cat != 0){
            $cat = PCategory::find($home->cat);
            $pr = $cat->product()->where('publish', 1)->where('primary', 1)->orderByRaw("RAND()")->take(4)->get();
            if(count($pr) > 0){
                foreach($pr as $p){
                    $featured[] = $p;
                }
            }
            $featured = array_slice($featured, 0, 4);
        }
        return $featured;
    }

    public static function getColorsList(){
        return Attribute::leftJoin('properties', 'attributes.property_id', '=', 'properties.id')
            ->where('properties.id', 12)->pluck('attributes.title', 'attributes.id')
            ->prepend('Odaberite boju', 0)->toArray();
    }

    public static function getMaterialsList(){
        return Attribute::leftJoin('properties', 'attributes.property_id', '=', 'properties.id')
            ->where('properties.id', 14)
            ->pluck('attributes.title', 'attributes.id')
            ->prepend(trans('language.Select material'), 0)->toArray();
    }

    public static function getMaterialListByProduct($product_id){
        return Attribute::leftJoin('properties', 'attributes.property_id', '=', 'properties.id')
            ->leftJoin('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
            ->leftJoin('products', 'attribute_product.product_id', '=', 'products.id')
            ->where('properties.id', 14)->where('products.id', $product_id)
            ->pluck('attributes.title', 'attributes.id')
            ->prepend(trans('language.Select material'), 0)->toArray();
    }

    public static function getMaterialListByProductFront($product_id){
        return Attribute::leftJoin('properties', 'attributes.property_id', '=', 'properties.id')
            ->leftJoin('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
            ->leftJoin('products', 'attribute_product.product_id', '=', 'products.id')
            ->where('properties.id', 14)->where('products.id', $product_id)
            ->pluck('attributes.title', 'attributes.id')
            ->toArray();
    }

    public static function searchProducts($text){
        $settings = Settings::first();
        if($settings->amount){
            $products = self::select('products.id', 'products.image', 'products.price_outlet', 'products.price_small')
                ->leftJoin('product_translations', 'products.id', '=', 'product_translations.product_id')
                ->where('publish', 1)->where(function ($query) use ($text) {
                    $query->where('product_translations.title', 'LIKE', '%'.$text.'%')->orWhere('product_translations.slug', 'LIKE', '%'.$text.'%')->orWhere('product_translations.short', 'LIKE', '%'.$text.'%');
                })->where('product_translations.locale', app()->getLocale())
                ->orderby('publish_at', 'DESC')->take(36)->get();
        }else{
            $products = self::select('products.id', 'products.image', 'products.price_outlet', 'products.price_small')
                ->leftJoin('product_translations', 'products.id', '=', 'product_translations.product_id')
                ->where('publish', 1)->where('amount', '>', 0)->where(function ($query) use ($text) {
                    $query->where('product_translations.title', 'LIKE', '%'.$text.'%')->orWhere('product_translations.slug', 'LIKE', '%'.$text.'%')->orWhere('product_translations.short', 'LIKE', '%'.$text.'%');
                })->where('product_translations.locale', app()->getLocale())
                ->orderby('publish_at', 'DESC')->take(36)->get();
        }
        return $products;
    }

    public static function getPrimariesProducts($category_id, $product_id){
        return PCategory::find($category_id)->product()->select('products.id', 'product_translations.title')
            ->leftJoin('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('products.publish', 1)->where('products.id', '<>', $product_id)->where('product_translations.locale', app()->getLocale())
            ->pluck('product_translations.title', 'products.id')->prepend('Bez primarnog proizvoda', 0);
    }

    public static function getSubProducts($product_id){
        $product = self::find($product_id);
        return self::select('products.id', 'product_translations.title')
            ->leftJoin('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('products.publish', 1)->where('products.primary_id', $product_id)->where('product_translations.locale', app()->getLocale())
            ->pluck('product_translations.title', 'products.id')->prepend($product->{'title:'.app()->getLocale()}, $product->id)->prepend(trans('language.Select the type'), 0);
    }

    public static function getProductPriceByMaterial($product_id, $material_id=0){
        if($material_id == 0){
            $product = self::find($product_id);
            if($product->price_outlet > 0){ $cena = $product->price_outlet; }else{ $cena = $product->price_small; }
        }else{
            $c = DB::table('attribute_product')->select('price')->where('product_id', $product_id)->where('attribute_id', $material_id)->first();
            isset($c)? $cena = $c->price : $cena = -1;
        }
        return $cena;
    }

    public static function getProductSelect($locale='hr'){
        return self::join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('product_translations.locale', $locale)->where('products.publish', 1)->where('products.publish_at', '<=', (new \Carbon\Carbon()))
            ->pluck('product_translations.title', 'products.id');
    }

    public static function newFilteredAdminProducts($title=false, $cat=0, $limit, $sort=2, $min=0, $max=0){
        if($sort == 2){ $field = 'products.price_small'; $param = 'ASC'; }elseif($sort == 3){ $field = 'products.price_small'; $param = 'DESC'; }else{ $field = 'products.id'; $param = 'DESC'; }
        if($cat == 0){
            return Product::select('products.*')
                ->where(function($query) use ($title)
                {
                    if($title){
                        $query->where('products.title', 'LIKE', "%$title%")->orWhere('products.id', 'LIKE', "%$title%")->orWhere('products.slug', 'LIKE', "%$title%")
                            ->orWhere('products.code', 'LIKE', "%$title%")->orWhere('products.short', 'LIKE', "%$title%");
                    }
                })
                ->where(function($query) use ($min, $max)
                {
                    if($min > 0 && $max > 0){
                        $query->whereBetween('products.price_small', [$min, $max]);
                    }elseif($min > 0){
                        $query->where('products.price_small', '>=', $min);
                    }elseif($max > 0){
                        $query->where('products.price_small', '<=', $max);
                    }
                })
                ->groupby('products.id')
                ->orderby($field, $param)
                ->paginate($limit);
        }else{
            return Product::select('products.*')
                ->join('category_product', 'products.id', '=', 'category_product.product_id')
                ->join('categories', 'category_product.category_id', '=', 'categories.id')
                ->where('categories.id', $cat)
                ->where(function($query) use ($title)
                {
                    if($title){
                        $query->where('products.title', 'LIKE', "%$title%")->orWhere('products.id', 'LIKE', "%$title%")->orWhere('products.slug', 'LIKE', "%$title%")
                            ->orWhere('products.code', 'LIKE', "%$title%")->orWhere('products.short', 'LIKE', "%$title%");
                    }
                })
                ->where(function($query) use ($min, $max)
                {
                    if($min > 0 && $max > 0){
                        $query->whereBetween('products.price_small', [$min, $max]);
                    }elseif($min > 0){
                        $query->where('products.price_small', '>=', $min);
                    }elseif($max > 0){
                        $query->where('products.price_small', '<=', $max);
                    }
                })
                ->groupby('products.id')
                ->orderby($field, $param)
                ->paginate($limit);
        }
    }

    public static function newFilteredDiscountAdminProducts($title=false, $cat=0, $brand=0, $limit=50){
        if($cat == 0 && $brand == 0){
            return Product::select('products.*')
                ->where(function($query) use ($title)
                {
                    if($title){
                        $query->where('products.title', 'LIKE', "%$title%")->orWhere('products.id', 'LIKE', "%$title%")->orWhere('products.slug', 'LIKE', "%$title%")
                            ->orWhere('products.code', 'LIKE', "%$title%")->orWhere('products.short', 'LIKE', "%$title%");
                    }
                })
                ->groupby('products.id')
                ->orderby('id', 'desc')
                ->paginate($limit);
        }elseif($brand == 0){
            return Product::select('products.*')
                ->join('category_product', 'products.id', '=', 'category_product.product_id')
                ->join('categories', 'category_product.category_id', '=', 'categories.id')
                ->where('categories.id', $cat)
                ->where(function($query) use ($title)
                {
                    if($title){
                        $query->where('products.title', 'LIKE', "%$title%")->orWhere('products.id', 'LIKE', "%$title%")->orWhere('products.slug', 'LIKE', "%$title%")
                            ->orWhere('products.code', 'LIKE', "%$title%")->orWhere('products.short', 'LIKE', "%$title%");
                    }
                })
                ->groupby('products.id')
                ->orderby('id', 'desc')
                ->paginate($limit);
        }elseif($cat == 0){
            return Product::select('products.*')
                ->where('products.brand_id', $brand)
                ->where(function($query) use ($title)
                {
                    if($title){
                        $query->where('products.title', 'LIKE', "%$title%")->orWhere('products.id', 'LIKE', "%$title%")->orWhere('products.slug', 'LIKE', "%$title%")
                            ->orWhere('products.code', 'LIKE', "%$title%")->orWhere('products.short', 'LIKE', "%$title%");
                    }
                })
                ->groupby('products.id')
                ->orderby('id', 'desc')
                ->paginate($limit);
        }else{
            return Product::select('products.*')
                ->join('category_product', 'products.id', '=', 'category_product.product_id')
                ->join('categories', 'category_product.category_id', '=', 'categories.id')
                ->where('categories.id', $cat)
                ->where('products.brand_id', $brand)
                ->where(function($query) use ($title)
                {
                    if($title){
                        $query->where('products.title', 'LIKE', "%$title%")->orWhere('products.id', 'LIKE', "%$title%")->orWhere('products.slug', 'LIKE', "%$title%")
                            ->orWhere('products.code', 'LIKE', "%$title%")->orWhere('products.short', 'LIKE', "%$title%");
                    }
                })
                ->groupby('products.id')
                ->orderby('id', 'desc')
                ->paginate($limit);
        }
    }

    public static function filteredProducts($cat=0, $fil, $sort=2, $min=0, $max=0, $minPromer=0, $maxPromer=0, $minWater=0, $maxWater=0){
        if($sort == 2){ $field = 'products.price_outlet'; $param = 'ASC'; }elseif($sort == 3){ $field = 'products.price_outlet'; $param = 'DESC'; }else{ $field = 'products.publish_at'; $param = 'DESC'; }
        if($cat == 0){
            if(count($fil) > 0){
                return Product::select('products.*', DB::raw('count(products.id) as broj'))
                    ->join('attribute_product','products.id','=','attribute_product.product_id')
                    ->join('attributes','attribute_product.attribute_id','=','attributes.id')
                    ->join('properties','attributes.property_id','=','properties.id')
                    ->where(function($query) use ($fil)
                    {
                        if(count($fil) > 0){
                            $query->whereIn('attributes.id', $fil);
                        }
                    })
                    ->where(function($query) use ($min, $max)
                    {
                        if($max > 0){
                            $query->whereBetween('products.price_outlet', [$min, $max]);
                        }
                    })
                    ->where(function($query) use ($minPromer, $maxPromer)
                    {
                        if($maxPromer > 0){
                            $query->whereBetween('products.diameter', [$minPromer, $maxPromer]);
                        }
                    })
                    ->where(function($query) use ($minWater, $maxWater)
                    {
                        if($maxWater > 0){
                            $query->whereBetween('products.water', [$minWater, $maxWater]);
                        }
                    })
                    ->where('products.publish', 1)
                    ->groupby('products.id')
                    ->orderby($field, $param)
                    ->get();
            }else{
                return Product::select('products.*', DB::raw('count(products.id) as broj'))
                    ->where(function($query) use ($min, $max)
                    {
                        if($max > 0){
                            $query->whereBetween('products.price_outlet', [$min, $max]);
                        }
                    })
                    ->where(function($query) use ($minPromer, $maxPromer)
                    {
                        if($maxPromer > 0){
                            $query->whereBetween('products.diameter', [$minPromer, $maxPromer]);
                        }
                    })
                    ->where(function($query) use ($minWater, $maxWater)
                    {
                        if($maxWater > 0){
                            $query->whereBetween('products.water', [$minWater, $maxWater]);
                        }
                    })
                    ->where('products.publish', 1)
                    ->groupby('products.id')
                    ->orderby($field, $param)
                    ->get();
            }
        }else{
            if(count($fil) > 0){
                return Product::select('products.*', DB::raw('count(products.id) as broj'))
                    ->join('category_product', 'products.id', '=', 'category_product.product_id')
                    ->join('categories', 'category_product.category_id', '=', 'categories.id')
                    ->join('attribute_product','products.id','=','attribute_product.product_id')
                    ->join('attributes','attribute_product.attribute_id','=','attributes.id')
                    ->join('properties','attributes.property_id','=','properties.id')
                    ->where('categories.id', $cat)
                    ->where(function($query) use ($fil)
                    {
                        if(count($fil) > 0){
                            $query->whereIn('attributes.id', $fil);
                        }
                    })
                    ->where(function($query) use ($min, $max)
                    {
                        if($max > 0){
                            $query->whereBetween('products.price_outlet', [$min, $max]);
                        }
                    })
                    ->where(function($query) use ($minPromer, $maxPromer)
                    {
                        if($maxPromer > 0){
                            $query->whereBetween('products.diameter', [$minPromer, $maxPromer]);
                        }
                    })
                    ->where(function($query) use ($minWater, $maxWater)
                    {
                        if($maxWater > 0){
                            $query->whereBetween('products.water', [$minWater, $maxWater]);
                        }
                    })
                    ->where('products.publish', 1)
                    ->groupby('products.id')
                    ->orderby($field, $param)
                    ->get();
            }else{
                return Product::select('products.*', DB::raw('count(products.id) as broj'))
                    ->join('category_product', 'products.id', '=', 'category_product.product_id')
                    ->join('categories', 'category_product.category_id', '=', 'categories.id')
                    ->where('categories.id', $cat)
                    ->where(function($query) use ($min, $max)
                    {
                        if($max > 0){
                            $query->whereBetween('products.price_outlet', [$min, $max]);
                        }
                    })
                    ->where(function($query) use ($minPromer, $maxPromer)
                    {
                        if($maxPromer > 0){
                            $query->whereBetween('products.diameter', [$minPromer, $maxPromer]);
                        }
                    })
                    ->where(function($query) use ($minWater, $maxWater)
                    {
                        if($maxWater > 0){
                            $query->whereBetween('products.water', [$minWater, $maxWater]);
                        }
                    })
                    ->where('products.publish', 1)
                    ->groupby('products.id')
                    ->orderby($field, $param)
                    ->get();
            }
        }
    }

    public static function filtered($products, $count, $limit, $sort=2, $oo){
        if($sort == 2){ $field = 'products.price_small'; $param = 'ASC'; }elseif($sort == 3){ $field = 'products.price_small'; $param = 'DESC'; }else{ $field = 'products.publish_at'; $param = 'DESC'; }
        $res = array();
        if(count($products)>0){
            foreach($products as $p){
                if($p->broj >= $count){
                    $res[] = $p->id;
                }
            }
        }
        $res = Property::isGroup($res, $oo);
        if(count($res)){
            return self::whereIn('id', $res)->orderby($field, $param)->paginate($limit);
        }else{
            return self::whereIn('id', [0])->paginate($limit);
        }
    }

    public static function addToWishList($id){
        $cookie = \App::make('CodeZero\Cookie\Cookie');
        //$cookie->delete('eleganza');
        $array = array();
        $old = $cookie->get('eleganza');
        $br = true;
        if(count($old)>0){
            foreach($old as $o){
                if($o == $id){
                    $br = false;
                }
                $array[] = $o;
            }
            if($br){
                $array[] = $id;
            }
        }else{
            $array[] = $id;
        }
        $cookie->store('eleganza', $array, 259200);//180 dana
        return $cookie->get('eleganza');
    }

    public static function removeFromWishList($id){
        $cookie = \App::make('CodeZero\Cookie\Cookie');
        //$cookie->delete('eleganza');
        $array = array();
        $old = $cookie->get('eleganza');
        if(count($old)>0){
            foreach($old as $o){
                if($o != $id){
                    $array[] = $o;
                }
            }
        }
        $cookie->store('eleganza', $array, 259200);//180 dana
        return $cookie->get('eleganza');
    }

    public static function addToCart($id, $count=1, $omot=false){
        $cart = session('cart');
        $array = [];
        if(!isset($cart[0])){
            $array[] = array('id' => $id, 'count' => $count, 'omot' => $omot);
            session()->put('cart', $array);
        }else{
            $bool = false;
            foreach ($cart as $item){
                $array[] = $item;
                if($item['id'] != $id){
                    $bool = true;
                }
            }
            if($bool){
                $array[] =  array('id' => $id, 'count' => $count, 'omot' => $omot);
                session()->put('cart', $array);
            }
        }
        return 'done';
    }

    public static function removeFromCart($id=false){
        $cart = \Session::get('cart');
        if($id){
            if(count($cart)>0){
                $array = array();
                foreach($cart as $o){
                    if($o['id'] != $id){
                        $array[] = $o;
                    }
                }
                session()->put('cart', $array);
                return 'done';
            }
        }else{
            session()->put('cart', []);
            return 'done';
        }
    }

    public static function getCartIds(){
        $array = [];
        if(count(session('cart'))>0){
            foreach (session('cart') as $product){
                $array[] = $product['id'];
            }
        }
        return $array;
    }

    public static function countCookieProduct(){
        $cookie = self::getCookie();
        $br=0;
        if(count($cookie)>0){
            foreach($cookie as $c){
                $pro = self::find($c['id']);
                if(isset($pro)){ $br++; }
            }
        }
        return $br;
    }

    public static function cropImage($product){
        $extension = File::extension($product->image);
        $tmb = 'images/products/thumbnails/'.$product->{'slug:hr'}.'-'.$product->id.'.'.$extension;
        $img = \Image::make($product->image);
        $img->fit(270, 400);
        $img->save($tmb);
        $product->tmb = $tmb;
        $product->update();
    }

    public static function getCookie(){
        $cookie = \App::make('CodeZero\Cookie\Cookie');
        return $cookie->get('eleganza');
    }

    public static function paginateRender($products, $limit, $sort=2){
        if($sort == 2){ $field = 'products.price_small'; $param = 'ASC'; }elseif($sort == 3){ $field = 'products.price_small'; $param = 'DESC'; }else{ $field = 'products.publish_at'; $param = 'DESC'; }
        return self::whereIn('id', $products->pluck('id')->toArray())->orderby($field, $param)->paginate($limit);
    }

    public static function getFiltersByCheckboxes($products, $locale = 'hr'){
        return Attribute::select('attributes.id')
            ->join('attribute_translations', 'attributes.id', '=', 'attribute_translations.attribute_id')
            ->join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
            ->join('products', 'attribute_product.product_id', '=', 'products.id')
            ->where('attributes.publish', 1)->where('products.publish', 1)->whereIn('products.id', $products->pluck('id'))
            ->where('attribute_translations.locale', $locale)
            ->groupBy('attributes.id')->pluck('attributes.id')->toArray();
    }

    public static function base64UploadImage($product_id, $image){
        $product = Product::find($product_id);
        $exploaded = explode(',', $image);
        $data = base64_decode($exploaded[1]);
        $filename = $product->{'slug:hr'} . '-' . $product->id . '.jpg';
        $path = public_path('images/products/');
        file_put_contents($path . $filename, $data);
        $product->image = 'images/products/' . $filename;

        Helper::setProductTmbImage($product);
        $product->tmb = 'images/products/tmb/' . $filename;
        $product->update();
    }

    public static function calculateDiscount($price_small, $percent=0){
        if($percent == 0){
            return $price_small;
        }else{
            return $price_small - round(($percent/100) * $price_small, 2);
        }
    }

    public static function cloneProduct($num=1, $category_id=false){
        for($i=0;$i<$num;$i++){

            if($category_id != false){
                $category = Category::find($category_id);
                $product = $category->product()->inRandomOrder()->first();
            }else{
                $product = Product::inRandomOrder()->first();
            }

            $new = new Product();
            $new->user_id = $product->user_id;
            $new->brand_id = $product->brand_id;
            $new->set_id = $product->set_id;
            $new->code = str_random(7);
            $new->image = $product->image;
            $new->tmb = $product->tmb;
            $new->price_small = $product->price_small;
            $new->price_outlet = $product->price_outlet;
            $new->views = $product->views;
            $new->amount = $product->amount;
            $new->featured = $product->featured;
            $new->color = $product->color;
            $new->discount = 0;
            $new->sold = 0;
            $new->publish_at = $product->publish_at;
            $new->publish = 1;

            $new->title = $product->title;
            $new->slug = $product->slug;
            $new->short = $product->short;
            $new->body = $product->body;
            $new->body2 = $product->body2;

            $new->save();

            if(count($product->category)>0){
                $ids = $product->category()->pluck('categories.id');
                $new->category()->sync($ids);
            }
        }

        return 'done';
    }

    public static function isNewProduct($product){
        if(Carbon::now()->subDays(30) < $product->publish_at){
            return true;
        }else{
            return false;
        }
    }

    public function getCollection(){
        $collection = Attribute::join('attribute_product', 'attributes.id', '=', 'attribute_product.attribute_id')
            ->where('attribute_product.product_id', $this->id)->where('attributes.property_id', 33)->first();
        return $collection? $collection->title : null;
    }

    public function similarProducts(){
        $ids = $this->attribute()->where('attributes.extra', null)->pluck('attributes.id')->toArray();
        return self::select('products.*')->join('attribute_product', 'products.id', '=', 'attribute_product.product_id')->join('attributes', 'attribute_product.attribute_id', '=', 'attributes.id')
            ->where(function($query) use ($ids){
                $query->whereIn('attributes.id', $ids);

            })
            ->where('products.id', '<>', $this->id)->groupBy('products.id')
            ->havingRaw('COUNT(DISTINCT attributes.id) = ' . count($ids))->get();
    }

    public function getFullImagePathAttribute(){
        return url($this->image);
    }

    public function brand(){
        return $this->belongsTo('App\Brand');
    }

    public function category(){
        return $this->belongsToMany('App\Category');
    }

    public function post(){
        return $this->belongsToMany('App\Post');
    }

    public function cart(){
        return $this->belongsToMany('App\Cart');
    }

    public function attribute(){
        //return $this->belongsToMany('App\Attribute')->withPivot('price');
        return $this->belongsToMany('App\Attribute');
    }

    public function images(){
        return $this->hasMany('App\Images');
    }

    public function newsletter(){
        return $this->belongsToMany('App\Newsletter');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function set(){
        return $this->belongsTo('App\Set');
    }

    public function message(){
        return $this->hasMany(Message::class);
    }

    public function group(){
        return $this->belongsToMany(Group::class);
    }

    public function coordinate(){
        return $this->hasMany(Coordinate::class);
    }
}

