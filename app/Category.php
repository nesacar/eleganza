<?php

namespace App;

use App\Traits\UploudableImageTrait;
use Illuminate\Database\Eloquent\Model;
use Session;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use UploudableImageTrait;

    public static $list_limit = 50;

    protected $table = 'categories';

    protected $fillable = ['id', 'brand_id', 'title', 'slug', 'desc', 'order', 'parent', 'level', 'image', 'feature_image', 'collection', 'publish'];

    protected static function boot(){
        parent::boot();

        static::addGlobalScope('parentCategory', function (Builder $builder) {
            $builder->with(['parentCategory' => function($query){
                $query->where('publish', 1);
            }]);
        });
    }

    public function getLink(){
        $str = '';
        if(!empty($parent = $this->parentCategory)){
            $str = $parent->slug . '/';
            if(!empty($parent2 = $parent->parentCategory)){
                $str = $parent2->slug . '/' . $str;
                if(!empty($parent3 = $parent2->parentCategory)){
                    $str = $parent3->slug . '/' . $str;
                }
            }
        }
        $str = 'shop/' . $str . $this->slug . '/';
        return url($str);
    }

    public function getBreadcrumb(){
        $str = '';
        if(!empty($parent = $this->parentCategory)){
            $str = '<li class="breadcrumb-item"><a href="' . $parent->getLink() . '">' . $parent->title . '</a></li>' . $str;
            if(!empty($parent2 = $parent->parentCategory)){
                $str = '<li class="breadcrumb-item"><a href="' . $parent2->getLink() . '">' . $parent2->title . '</a></li>' . $str;
                if(!empty($parent3 = $parent2->parentCategory)){
                    $str = '<li class="breadcrumb-item"><a href="' . $parent3->getLink() . '">' . $parent3->title . '</a></li>' . $str;
                }
            }
        }

        $str = '<nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="'. url('/') . '">Home</a></li>' . $str . '<li class="breadcrumb-item active" aria-current="page">' . $this->title . '</li></ol></nav>';

        return $str;
    }

    public static function tree($parent = 0) {
        return static::with(implode('.', array_fill(0, 1, 'children')))->where('parent', $parent)->get();
    }

    public function parentCategory() {
        return $this->hasOne(self::class, 'id', 'parent');
    }

    public function children() {
        return $this->hasMany(self::class, 'parent', 'id');
    }

    public static function save_cat_order($niz){
        $i=-1;
        foreach($niz as $n){
            $i++;
            if($i>0){
                if($n['parent_id'] == null){
                    self::save_order($n['item_id'], $i, false, $n['depth']);
                }else{
                    self::save_order($n['item_id'], $i, $n['parent_id'], $n['depth']);
                }
            }
        }
    }

    public static function save_order($id, $poz, $parent = false, $depth){
        if($parent){
            self::findOrFail($id)->update(array('order' => $poz, 'parent' => $parent, 'level' => $depth));
        }else{
            self::findOrFail($id)->update(array('order' => $poz, 'parent' => 0, 'level' => $depth));
        }
    }

    public static function getSortCategory($cat = false){
        if($cat){
            $category = self::where(array('publish' => 1, 'parent' => $cat))->orderby('order', 'ASC')->get();
        }else{
            $category = self::where(array('publish' => 1, 'parent' => 0))->orderby('order', 'ASC')->get();
        }
        $str="";
        if(isset($category)){
            $str .=  "<ol class='sortable'>";
            foreach($category as $c){
                $str .= "<li id='list_{$c->id}'><div>{$c->title}  /  {$c->id}</div>";
                $str .= self::getSortCategory($c->id);
                $str .= "</li>";
            }
            $str .= "</ol>";
        }
        return $str;
    }

    public static function getMobileNav($topCat, $info){
        $settings = Setting::first();
        $str = '<ul>';
        if(app()->getLocale() == 'sr'){
            $str .= '<li style="display: flex; display: -webkit-flex;">
                        <a href="'. url('sr').'" style="flex: 1; color: #d9241b;">srb</a>
                        <a href="'. url('en').'" style="flex: 1;">eng</a>
                        <a href="'. url('ru').'" style="flex: 1;">рус</a>
                        <a style="flex: 1;"></a>
                    </li>';
            $str .= '<li><a href="'. url('/').'">Početna</a></li>';
        }elseif(app()->getLocale() == 'en'){
            $str .= '<li style="display: flex; display: -webkit-flex;">
                        <a href="'. url('sr').'" style="flex: 1;">srb</a>
                        <a href="'. url('en').'" style="flex: 1; color: #d9241b;">eng</a>
                        <a href="'. url('ru').'" style="flex: 1;">рус</a>
                        <a style="flex: 1;"></a>
                    </li>';
            $str .= '<li><a href="'. url('/').'">Home</a></li>';
        }else{
            $str .= '<li style="display: flex; display: -webkit-flex;">
                        <a href="'. url('sr').'" style="flex: 1;">srb</a>
                        <a href="'. url('en').'" style="flex: 1;">eng</a>
                        <a href="'. url('ru').'" style="flex: 1; color: #d9241b;">рус</a>
                        <a style="flex: 1;"></a>
                    </li>';
            $str .= '<li><a href="'. url('/').'">Главная</a></li>';
        }
        if(count($topCat)){
            foreach($topCat as $top){
                $cat = self::getChild($top->id);
                if(count($cat)) {
                    $str .= '<li class="icon icon-arrow-left">';
                    $str .= '<a href="#">'.$top->title.'</a>';
                    $str .= '<div class="mp-level">';
                    $str .= '<h2 class="icon icon-display">'.$top->title.'</h2>';
                    if(app()->getLocale() == 'sr'){
                        $str .= '<a class="mp-back" href="#">Nazad</a>';
                    }elseif(app()->getLocale() == 'en'){
                        $str .= '<a class="mp-back" href="#">Back</a>';
                    }else {
                        $str .= '<a class="mp-back" href="#">Назад</a>';
                    }

                    $str .= '<ul>';
                    foreach($cat as $c){
                        $list = self::where('parent', $c->id)->where('publish', 1)->orderby('order', 'ASC')->get();
                        if(count($list) > 0){
                            $str .= self::getShopMobileMenu($list, $c->title, false);
                        }else{
                            $str .= '<li><a href="'. url(self::getShopLink($c->id)) .'">'.$c->title.'</a></li>';
                        }
                    }
                    $str .= '</ul>';

                    $str .= '</div></li>';
                }else{
                    $str .= '<li><a href="'.url($top->slug).'">'.$top->title.'</a></li>';
                }
            }
        }
        $str .= '<li style="display: flex; display: -webkit-flex;">
                    <a href="' . $settings->facebook . '" style="flex: 1; text-align: center; padding-left: 0; padding-right: 0;" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="' . $settings->pinterest . '" style="flex: 1; text-align: center; padding-left: 0; padding-right: 0;" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                    <a href="' . $settings->instagram . '" style="flex: 1; text-align: center; padding-left: 0; padding-right: 0;" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </li>';
        if(false) {
            $str .= '<li><a href="' . url('info/o-nama/5') . '">O nama</a></li>';
            $str .= '<li><a href="' . url('info/marketing/10') . '">MARKETING</a></li>';
            $str .= '<li><a href="' . url('info/uputstvo/11') . '">UPUTSTVO</a></li>';
            $str .= '<li><a href="' . url('info/kontakt/7') . '">Kontakt</a></li>';
            $str .= '<li><a href="' . url('info/uslovi-koriscenja') . '">Uslovi korišćenja</a></li>';
        }
        $str .= '</ul>';
        return $str;
    }

    /*public static function getChildCategories($cat){
        $res = '';
        $res .= $cat.',';
        $child = self::where('parent', $cat)->get();
        if(count($child) > 0){
            foreach($child as $ch){
                $res .= $ch->id.',';
                $child = self::where('parent', $ch->id)->get();
                if(count($child) > 0){
                    $res .= self::getChildCategories($ch->id);
                }
            }
        }
        return $res;
    }*/

    public static function getShopMobileMenu($list, $parent, $first=true){
        $str='';

        if(count($list)){
            if($first){
                $str .= '<ul>';
            }

            $str .= '<li class="icon icon-arrow-left">';
            $str .= '<a href="#">'.$parent.'</a>';
            $str .= '<div class="mp-level">';
            $str .= '<a class="mp-back" href="#">nazad</a>';
            $str .= '<ul>';

            foreach($list as $l){
                $list2 = self::where('parent', $l->id)->where('publish', 1)->orderby('order', 'ASC')->get();
                if(count($list2)){
                    $str .= self::getShopMobileMenu($list2, $l->title);
                }else{
                    $str .= '<li><a href="'. url(self::getShopLink($l->id)) .'">'.$l->title.'</a></li>';
                }
            }
            $str .= '</ul></div></li>';

            if($first){
                $str .= '</ul>';
            }
        }

        return $str;
    }

    public static function getChild($id){
        return self::where(array('publish' => 1, 'parent' => $id))->orderby('order', 'ASC')->get();
    }

    public static function getCategorySelect($locale, $except=false, $parent=false){
        return self::select('category_translations.title as title', 'categories.id as id')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.locale', $locale)->where('categories.publish', 1)
            ->where(function ($query) use ($except){
                if($except){
                    $query->where('categories.id', '<>', $except);
                }
            })->where(function ($query) use ($parent){
                if($parent){
                    $query->where('categories.parent', $parent);
                }
            })->pluck('category_translations.title', 'categories.id');
    }

    public static function getCategorySelectAdmin($locale, $except=false, $parent=false){
        return self::select('category_translations.title as title', 'categories.id as id')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.locale', $locale)->where('categories.publish', 1)
            ->where(function ($query) use ($except){
                if($except){
                    $query->where('categories.id', '<>', $except);
                }
            })->where(function ($query) use ($parent){
                if($parent){
                    $query->where('categories.parent', $parent);
                }
            })->pluck('category_translations.title', 'categories.id')->prepend('Sve kategorije', 0);
    }

    public static function getCategorySelectPrepend($locale, $except=false, $parent=false){
        return self::select('category_translations.title as title', 'categories.id as id')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.locale', $locale)->where('categories.publish', 1)
            ->where(function ($query) use ($except){
                if($except){
                    $query->where('categories.id', '<>', $except);
                }
            })->where(function ($query) use ($parent){
                if($parent){
                    $query->where('categories.parent', $parent);
                }
            })->pluck('category_translations.title', 'categories.id')->prepend('Bez nad kategorije', 0);
    }

    /*public static function getLocaleCategories($parent=false){
        if($parent){
            return PCategory::where('publish', 1)->where('parent', $parent)->where(function ($query){
                if(app()->getLocale() == 'ru'){
                    $query->where('id', '<>', 15);
                }
            })->translatedIn(app()->getLocale())->orderby('order', 'ASC')->get();
        }else{
            return PCategory::where('publish', 1)->where('parent', 0)->where('parent', $parent)->where(function ($query){
                if(app()->getLocale() == 'ru'){
                    $query->where('id', '<>', 15);
                }
            })->translatedIn(app()->getLocale())->orderby('order', 'ASC')->get();
        }
    }*/

    public static function getCategoryLink($category, $locale = 'sr'){
        $link='';
        if($category){
            $link = url('shop/'.self::getShopLink($category->id, $locale));
        }
        return $link;
    }

    public static function getLangLink($locale, $cat=false, $post=false){
        $link='';
        if($post){
            $link = Post::getPostLink($post, $locale);
        }elseif($cat){
            $link = url($locale.'/'.self::getShopLink($cat, $locale));
        }
        return $link;
    }

    public static function getShopLink($id, $locale=false){
        $str = '';
        if($locale){
            $cat = self::find($id);
            if(isset($cat)){
                if($cat->parent > 0){
                    $str = $cat->{'slug:'.$locale}.'/'.$str;
                    $str = self::getShopLink($cat->parent, $locale).$str;
                }else{
                    $str = $cat->{'slug:'.$locale}.'/'.$str;
                }
            }
        }else{
            $cat = self::find($id);
            if(isset($cat)){
                if($cat->parent > 0){
                    $str = $cat->slug.'/'.$str;
                    $str = self::getShopLink($cat->parent).$str;
                }else{
                    $str = $cat->slug.'/'.$str;
                }
            }
        }
        return $str;
    }

    public static function isTranslate($category, $locale){
        if(isset($category)){
            $row = PCategoryTranslation::where('category_id', $category->id)->where('locale', $locale)->first();
            if(isset($row)){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public static function getSortCategoryRadio($cat = false, $catids){
        if($cat){
            $category = Category::where(array('publish' => 1, 'parent' => $cat))->orderby('order', 'ASC')->get();
        }else{
            $category = Category::where(array('publish' => 1, 'parent' => 0))->orderby('order', 'ASC')->get();
        }
        $str="";
        if(isset($category)){
            $str .=  "<ol class='sortable'>";
            foreach($category as $c){
                $str .= "<li id='list_{$c->id}' style='position: relative'>";
                $str .= "<div class='udesno'>{$c->title}}</div>";
                if (in_array($c->id, $catids)) {
                    $str .= "<input type='radio' name='parent' value='{$c->id}' checked='checked' class='right-sort'";
                    if($c->level > 3){ $str .= "disabled='true'"; }
                    $str .= ".>";
                }else {
                    $str .= "<input type='radio' name='parent' value='{$c->id}' class='right-sort'";
                    if($c->level > 3){ $str .= "disabled='true'"; }
                    $str .= ".>";
                }
                $str .= Category::getSortCategoryRadio($c->id, $catids);
                $str .= "</li>";
            }
            $str .= "</ol>";
        }
        return $str;
    }

    public static function getSortCategoryCheckbox($cat = false, $catids){
        if($cat){
            $category = Category::where(array('publish' => 1, 'parent' => $cat))->orderby('order', 'ASC')->get();
        }else{
            $category = Category::where(array('publish' => 1, 'parent' => 0))->orderby('order', 'ASC')->get();
        }
        $str="";
        if(count($category) > 0){
            $str .=  "<ol class='sortable'>";
            foreach($category as $c){
                $str .= "<li id='list_{$c->id}' style='position: relative'>";
                $str .= "<div class='udesno'>{$c->title}</div>";
                if (in_array($c->id, $catids)) {
                    $str .= "<input type='checkbox' name='kat[]' value='{$c->id}' checked='checked' class='right-sort'>";
                }else {
                    $str .= "<input type='checkbox' name='kat[]' value='{$c->id}' class='right-sort'>";
                }
                $str .= self::getSortCategoryCheckbox($c->id, $catids);
                $str .= "</li>";
            }
            $str .= "</ol>";
        }
        return $str;
    }

    public static function getSortCategorySelectAdmin($cat=false){
        $category = self::where(array('parent' => 0))->orderby('order', 'ASC')->get();
        $str="";
        if(isset($category)){
            $str .=  "<select name='category_id' class='sele' id='kategorija'>";
            $str .=  "<option value='0'>Sve kategorije</option>";
            foreach($category as $c){
                $separator = self::getSeparator($c->level);
                $str .=  "<option value='{$c->id}'";
                if($cat){
                    if($cat == $c->id){ $str .= "selected>"; }else{ $str .= ">"; }
                }else{
                    if(Session::get('cat') == $c->id){ $str .= "selected>"; }else{ $str .= ">"; }
                }
                $str .= $separator." {$c->order}. {$c->{'title:hr'}}";
                $str .= "</option>";
                $str .= self::getSortCategorySelectParentAdmin($c->id);
            }
            $str .= "</select>";
        }
        return $str;
    }

    /**
     * Get select tag list with nested categories
     *
     * @param int $cat
     * @param int $i
     * @return string
     */
    public static function getSortCategorySelect($cat = 0, $i = 0)
    {
        $str = '';
        // Get category with children category relations
        $categories = Category::tree($cat);

        if ($i == 0) {
            // Run only one, open tag
            $str = "<select name='category_id' class='sele' id='kategorija'>";
            $str .= "<option value='0'>Sve kategorije</option>";
            $i++;
        }
        foreach ($categories as $category) {

            $separator = self::getSeparator($category->level);

            $str .= "<option value='$category->id'";
            Session::get('cat') == $category->id ? $str .= "selected" : $str .= '';
            $str .= ">$separator$category->order $category->title</option>";

            if (!empty($category->children)) {
                // category have subcategory, run recursive
                $str .= self::getSortCategorySelect($category->id, $i++);
            }
        }
        return $str;
    }

    public static function getSortCategorySelectPosts(){
        $category = self::where(array('publish' => 1, 'parent' => 0))->where('level', '<', 4)->orderby('order', 'ASC')->get();
        $str="";
        if(isset($category)){
            $str .=  "<select name='category_id' class='form-control' id='kategorija'>";
            $str .=  "<option value='0'>Sve kategorije</option>";
            foreach($category as $c){
                $separator = self::getSeparator($c->level);
                $str .=  "<option value='{$c->id}'";
                if(Session::get('post_cat') == $c->id){ $str .= "selected>"; }else{ $str .= ">"; }
                $str .= $separator." {$c->order}. {$c->{'title:hr'}}";
                $str .= "</option>";
                $str .= self::getSortCategorySelectParent($c->id);
            }
            $str .= "</select>";
        }
        return $str;
    }

    public static function getSortCategorySelectParent($cat = false){
        $str="";
        if($cat){
            $category = self::where(array('publish' => 1, 'parent' => $cat))->where('level', '<', 4)->orderby('order', 'ASC')->get();
            if(isset($category)){
                foreach($category as $c){
                    $separator = self::getSeparator($c->level);
                    $str .=  "<option value='{$c->id}'";
                    if(Session::get('cat') == $c->id){ $str .= "selected>"; }else{ $str .= ">"; }
                    $str .= $separator." {$c->order}. {$c->{'title:hr'}}";
                    $str .= "</option>";
                    $str .= self::getSortCategorySelectParent($c->id);
                }
            }
        }
        return $str;
    }

    public static function getSortCategorySelectParentAdmin($cat = false){
        $str="";
        if($cat){
            $category = self::where(array('parent' => $cat))->where('level', '<', 4)->orderby('order', 'ASC')->get();
            if(isset($category)){
                foreach($category as $c){
                    $separator = self::getSeparator($c->level);
                    $str .=  "<option value='{$c->id}'";
                    if(Session::get('cat') == $c->id){ $str .= "selected>"; }else{ $str .= ">"; }
                    $str .= $separator." {$c->order}. {$c->{'title:hr'}}";
                    $str .= "</option>";
                    $str .= self::getSortCategorySelectParentAdmin($c->id);
                }
            }
        }
        return $str;
    }

    public static function getSeparator($id){
        $str = '';
        if($id == 2){
            $str .= '-';
        }elseif($id == 3){
            $str .= '--';
        }elseif($id == 4){
            $str .= '---';
        }
        elseif($id == 5){
            $str .= '----';
        }
        return $str;
    }

    public static function getLastCategoryObject($product){
        if(count($product->category)>0){
            $level = 0;
            $cat = null;
            foreach ($product->category as $category){
                if($category->level > $level){
                    $level = $category->level;
                    $cat = $category;
                }
            }
            return $cat;
        }
        return null;
    }

    public static function add100($cats){
        if(count($cats)>0){
            $res = [];
            foreach($cats as $cat){
                $res[] = $cat + 100;
            }
            return $res;
        }
        return [];
    }

    public static function getCollections($id=false){
        if($id){
            return self::where('parent', $id)->where('publish', 1)->orderby('order', 'ASC')->get();
        }else{
            return self::where('level', 1)->where('publish', 1)->orderby('order', 'ASC')->get();
        }
    }

    public static function getBredcrumb($cat, $niz=false){
        if(!$niz){ $niz = array(); }
        $category = self::find($cat);
        if(isset($category)){
            $parent = self::where('id', $category->parent)->first();
            if(isset($parent)){
                $niz[] = $parent->id;
                $niz = self::getBredcrumb($parent->id, $niz);
            }
        }
        return $niz;
    }

    public static function getShopCategories($id, $main_category=false, $cat=false, $first=false){
        $str='';

        if(!$main_category){
            $main_category = self::getMainCategory($id);
            $children = self::where('publish', 1)->where('parent', $main_category->id)->orderby('order', 'ASC')->get();
        }else{
            $children = self::where('publish', 1)->where('parent', $cat->id)->orderby('order', 'ASC')->get();
        }

        if(isset($children)){

            if($first){
                $str.='<ul class="main-nav">';
            }else{
                $str.='<ul class="sek open">';
            }

            foreach($children as $ch){
                $str.='<li';
                $link = url('shop/'.self::getShopLink($ch->id));
                if($first){
                    $str.=' class="topic"><a href="'.$link.'"';
                }else{
                    $str.='><a href="'.$link.'"';
                }
                if($ch->id == $id){
                    $str.=' class="active">'.$ch->title.'</a>';
                    //ovde se prikazuju
                    $str.=self::getCategoryChildren($ch->id);
                }else{
                    $str.='>'.$ch->title.'</a>';
                }
                if(self::isParentContainsThisChild($ch->id, $id)){
                    $str.= $s = self::getShopCategories($id, true, $ch);
                }
                if($first){
                    $str.='<span class="num" style="top: 9px">'.$ch->product()->where('amount', '>', 0)->where('publish', 1)->count().'</span></li>';
                }else{
                    $str.='<span class="num">'.$ch->product()->where('amount', '>', 0)->where('publish', 1)->count().'</span></li>';
                }
            }
            $str.='</ul>';
        }

        return $str;
    }

    public static function getMainCategory($id){
        $category = self::find($id);
        $parent  = self::where('publish', 1)->where('id', $category->parent)->first();
        if(isset($parent)){
            $category = self::getMainCategory($parent->id);
        }
        return $category;
    }

    public static function isParentContainsThisChild($parent, $child){
        $res=false;
        $ch1 = self::where('publish', 1)->where('parent', $parent)->where('id', $child)->first();
        if(isset($ch1)){
            $res=true;
        }else{
            $children = self::where('publish', 1)->where('parent', $parent)->get();
            if(count($children)){
                foreach($children as $ch){
                    $res = self::isParentContainsThisChild($ch->id, $child);
                    if($res) break;
                }
            }
        }
        return $res;
    }

    public static function getCategoryChildren($id){
        $str='';
        $children = self::where('publish', 1)->where('parent', $id)->orderby('order', 'ASC')->get();
        if(count($children)){
            $str.='<ul class="sek open">';
            foreach($children as $ch){
                $link = url('shop/'.self::getShopLink($ch->id));
                $str.='<li><a href="'.$link.'">'.$ch->title.'</a><span class="num">'.$ch->product()->where('amount', '>', 0)->where('publish', 1)->count().'</span></li>';
            }
            $str.='</ul>';
        }

        return $str;
    }

    public static function getSetByTopCategory($product){
        $category = Category::select('categories.*')->join('category_product', 'categories.id', '=', 'category_product.category_id')
            ->where('category_product.product_id', $product->id)->where('categories.parent', 0)->first();
        if(!empty($category)){
            return Set::where('slug', $category->slug)->first();
        }
    }

    public static function prepareCategoryFromVueExcelTable($cat1, $cat2, $cat3, $cat4){
        $array = array();
        if(!empty($cat1)) $array[] = $cat1;
        if(!empty($cat2)) $array[] = $cat2;
        if(!empty($cat3)) $array[] = $cat3;
        if(!empty($cat4)) $array[] = $cat4;
        return $array;
    }

    public function post(){
        return $this->hasMany(Post::class);
    }

    public function product(){
        return $this->belongsToMany(Product::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function property(){
        return $this->belongsToMany(Property::class);
    }

}
