<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Block;
use App\Box;
use App\Brand;
use App\Cart;
use App\Category;
use App\Click;
use App\Coupon;
use App\Customer;
use App\Group;
use App\Helper;
use App\Http\Requests\CartOrderRequest;
use App\Http\Requests\CustomerRegisterRequest;
use App\Http\Requests\ListKupovineRequest;
use App\Http\Requests\SendKontaktFormRequest;
use App\Http\Requests\SubscribeRequest;
use App\Language;
use App\Mail\CartOrder;
use App\Mail\LuxLifeNewsletter;
use App\Mail\OrderIsReadyMail;
use App\Mail\RegisterConfirmationMail;
use App\Menu;
use App\MenuLink;
use App\Newsletter;
use App\PCategory;
use App\Post;
use App\Product;
use App\Property;
use App\Set;
use App\Setting;
use App\ShoppingCart;
use App\Subscriber;
use App\Tag;
use App\Theme;
use App\User;
use Illuminate\Http\Request;
use Cookie;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    public static $paginate = 20;
    public static $paginateTag = 24;

    public function __construct(){
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
    }

    public function index(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $hero = Block::find(4)->box()->where('publish', 1)->orderBy('order', 'ASC')->first();
        $hero2 = Block::find(4)->box()->where('publish', 1)->orderBy('order', 'ASC')->skip(1)->first();
        $home4 = Block::find(2)->box()->where('publish', 1)->orderBy('order', 'ASC')->get();
        $home1 = Block::find(3)->box()->where('publish', 1)->orderBy('order', 'ASC')->first();
        $home12 = Block::find(3)->box()->where('publish', 1)->orderBy('order', 'ASC')->skip(1)->first();
        $posts = Post::where('publish', 1)->where('home', 1)->where('publish_at', '<=', (new \Carbon\Carbon()))->orderBy('publish_at', 'DESC')->take(3)->get();
        $bestSellers = Group::find(1);
        $products = $bestSellers? $bestSellers->product()->where('publish', 1)->get() : [];
        return view('themes.'.$theme->slug.'.pages.home', compact('settings', 'theme', 'hero', 'hero2', 'home4', 'home1', 'home12', 'posts', 'products'));
    }

    public function shopCategory($slug){
        //return request()->all();
        \Session::forget('filter');
        $category = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug)->where('categories.publish', 1)->first();
        $s1 = $category;
        if(isset($category)){
            $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug)->first();
            if(!empty($set)){
                $props1 = $set->property()->where('properties.expanded', 0)->orderBy('properties.order', 'ASC')->get();
                $props2 = $set->property()->where('properties.expanded', 1)->orderBy('properties.order', 'ASC')->get();
            }else{
                $props1 = null;
                $props2 = null;
            }
            //$topParent = PCategory::getTopParentBySlug($slug);
            $bred = Category::getBredcrumb($category->id);
            $bred = array_reverse($bred);
            $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

            request('filters') ? $filters = request('filters') : $filters = [];
            //request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
            request('min-price') ? $price[0] = request('max-price') : $price[0] = 0;
            request('max-price') ? $price[1] = request('max-price') : $price[1] = 0;
            request('min-promer') ? $promer[0] = request('min-promer') : $promer[0] = 0;
            request('max-promer') ? $promer[1] = request('max-promer') : $promer[1] = 0;
            request('min-water') ? $water[0] = request('min-water') : $water[0] = 0;
            request('max-water') ? $water[1] = request('max-water') : $water[1] = 0;
            request('sort') ? $sort = request('sort') : $sort = 2;
            request('page') ? $page = request('page') : $page = 1;
            request('limit') ? $limit = request('limit') : $limit = 9;

            $count = Property::countPropertyFilter($filters);
            $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1], $promer[0], $promer[1], $water[0], $water[1]);
            //$properties = Property::getPropertiesAndAttributesByCategory($category->id);

            $filteri = Product::getFiltersByCategory($category->id);

            if($count > 0){
                $oo = Property::sredi($filters);
                $products = Product::filtered($products, $count, $limit, $sort, $oo);
            }else{
                $products = Product::paginateRender($products, $limit, $sort);
            }

            $max = Product::newMaxPrice($category->id, $filters);
            $theme = Theme::where('active', 1)->first();
            $settings = Setting::find(1);
            $topCat = [];
            $active = $slug;
            $s2 = null; $s3 = null; $s4 = null;
            return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 's4', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props1', 'props2', 'max', 'price', 'set'));
        }else{
            return 'error 404';
        }
    }

    public function shopCategory2($slug1, $slug2)
    {
        \Session::forget('filter');
        $s1 = $category = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug1)->where('categories.publish', 1)->first();
        $s2 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug2)->where('categories.publish', 1)->where('categories.parent', $s1->id)->first();
        $product = Product::find($slug2);
        $theme = Theme::where('active', 1)->first();
        $settings = Setting::find(1);
        $active = $slug1;
        if(isset($product)){
            if(request('email') && request('news')){
                $newsletter = Newsletter::where('verification', request('news'))->first();
                $subscriber = Subscriber::where('verification', request('email'))->first();
                if(isset($newsletter) && isset($subscriber)){
                    Click::insertProductClick($newsletter->id, $product->id, $subscriber->id);
                }
            }
            $topParent = PCategory::getTopParentBySlug($slug1);
            $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();
            $related = Product::getRelatedByCategory($category->id, $product->id, 4);
            if(count($product->post) == 0){
                $bre = Product::getBrendObject($product->id);
                if(isset($bre->id)){
                    $rel_cat = PCategory::where('slug', $bre->slug)->first();
                    $rel_posts = $rel_cat->post()->where('publish', 1)->where('publish_at', '<=', (new \Carbon\Carbon()))->where('order', '<>', 99)->orderby('publish_at', 'DESC')->take(2)->get();
                }else{
                    $rel_posts = array();
                }
            }
            $product->increment('views');
            $images = $product->images;
            $attributes = Attribute::getAttributesByProduct($product->id);
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 'related', 'rel_posts', 'settings', 'active', 'images', 'attributes'));
        }else{
            $category = $s2;
            if(isset($category)){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                if(!empty($set)){
                    $props1 = $set->property()->where('properties.expanded', 0)->orderBy('properties.order', 'ASC')->get();
                    $props2 = $set->property()->where('properties.expanded', 1)->orderBy('properties.order', 'ASC')->get();
                }else{
                    $props1 = null;
                    $props2 = null;
                }
                $topParent = PCategory::getTopParentBySlug($slug2);
                $bred = Category::getBredcrumb($category->id);
                $bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                //request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('min-price') ? $price[0] = request('max-price') : $price[0] = 0;
                request('max-price') ? $price[1] = request('max-price') : $price[1] = 0;
                request('min-promer') ? $promer[0] = request('min-promer') : $promer[0] = 0;
                request('max-promer') ? $promer[1] = request('max-promer') : $promer[1] = 0;
                request('min-water') ? $water[0] = request('min-water') : $water[0] = 0;
                request('max-water') ? $water[1] = request('max-water') : $water[1] = 0;
                request('sort') ? $sort = request('sort') : $sort = 2;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 9;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1], $promer[0], $promer[1], $water[0], $water[1]);
                //$properties = Property::getPropertiesAndAttributesByCategory($category->id);

                //$filteri = Product::getFiltersByCheckboxes($products);
                $filteri = Product::getFiltersByCategory($category->id);
                if($count > 0){
                    $oo = Property::sredi($filters);
                    $products = Product::filtered($products, $count, $limit, $sort, $oo);
                }else{
                    $products = Product::paginateRender($products, $limit, $sort);
                }
                $topCat = [];
                $max = Product::newMaxPrice($category->id, $filters);
                $s3 = null; $s4 = null;
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 's4', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props1', 'props2', 'max', 'set'));
            }else{
                return 'error 404';
            }
        }
    }


    public function shopCategory3($slug1, $slug2, $slug3)
    {
        $s1 = $category = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug1)->where('categories.publish', 1)->first();
        $product = Product::find($slug3);
        $theme = Theme::where('active', 1)->first();
        $settings = Setting::find(1);
        $active = $slug1;
        \Session::forget('filter');
        if(isset($product)){
            if(request('email') && request('news')){
                $newsletter = Newsletter::where('verification', request('news'))->first();
                $subscriber = Subscriber::where('verification', request('email'))->first();
                if(isset($newsletter) && isset($subscriber)){
                    Click::insertProductClick($newsletter->id, $product->id, $subscriber->id);
                }
            }
            $topParent = PCategory::getTopParentBySlug($slug1);
            $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();
            $related = Product::getRelatedByCategory($category->id, $product->id, 4);
            $rel_posts = array();
            $product->increment('views');
            $images = $product->images;
            $attributes = Attribute::getAttributesByProduct($product->id);
            $s2 = null; $s3 = null; $s4 = null;
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 's2', 's3', 's4', 'related', 'rel_posts', 'settings', 'theme', 'active', 'images', 'attributes'));
        }else{
            $s2 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug2)->where('categories.publish', 1)->where('categories.parent', $s1->id)->first();
            $category = $s3 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug3)->where('categories.publish', 1)->where('categories.parent', $s2->id)->first();
            if(isset($category)){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                if(!empty($set)){
                    $props1 = $set->property()->where('properties.expanded', 0)->orderBy('properties.order', 'ASC')->get();
                    $props2 = $set->property()->where('properties.expanded', 1)->orderBy('properties.order', 'ASC')->get();
                }else{
                    $props1 = null;
                    $props2 = null;
                }
                $topParent = PCategory::getTopParentBySlug($slug2);
                //$bred = Category::getBredcrumb($category->id);
                //$bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                //request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('min-price') ? $price[0] = request('max-price') : $price[0] = 0;
                request('max-price') ? $price[1] = request('max-price') : $price[1] = 0;
                request('min-promer') ? $promer[0] = request('min-promer') : $promer[0] = 0;
                request('max-promer') ? $promer[1] = request('max-promer') : $promer[1] = 0;
                request('min-water') ? $water[0] = request('min-water') : $water[0] = 0;
                request('max-water') ? $water[1] = request('max-water') : $water[1] = 0;
                request('sort') ? $sort = request('sort') : $sort = 2;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 9;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1], $promer[0], $promer[1], $water[0], $water[1]);
                //$properties = Property::getPropertiesAndAttributesByCategory($category->id);

                //$filteri = Product::getFiltersByCheckboxes($products);
                $filteri = Product::getFiltersByCategory($category->id);
                if($count > 0){
                    $oo = Property::sredi($filters);
                    $products = Product::filtered($products, $count, $limit, $sort, $oo);
                }else{
                    $products = Product::paginateRender($products, $limit, $sort);
                }

                $settings = Setting::find(1);
                $topCat = [];
                $max = Product::newMaxPrice($category->id, $filters);
                $s4 = null;
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 's4', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props1', 'props2', 'max', 'set'));
            }else{
                return 'error 404';
            }
        }
    }

    public function shopCategory4($slug1, $slug2, $slug3, $slug4){
        $s1 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug1)->where('categories.publish', 1)->first();
        $s2 = $category = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug2)->where('categories.publish', 1)->where('categories.parent', $s1->id)->first();
        $product = Product::find($slug4);
        $theme = Theme::where('active', 1)->first();
        $settings = Setting::find(1);
        $active = $slug1;
        \Session::forget('filter');
        if(isset($product)){
            if(request('email') && request('news')){
                $newsletter = Newsletter::where('verification', request('news'))->first();
                $subscriber = Subscriber::where('verification', request('email'))->first();
                if(isset($newsletter) && isset($subscriber)){
                    Click::insertProductClick($newsletter->id, $product->id, $subscriber->id);
                }
            }
            $topParent = PCategory::getTopParentBySlug($slug1);
            $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();
            $related = Product::getRelatedByCategory($category->id, $product->id, 4);
            $rel_posts = array();
            $product->increment('views');
            $images = $product->images;
            $attributes = Attribute::getAttributesByProduct($product->id);
            $s3 = null; $s4 = null;
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 's2', 's3', 's4', 's5', 'related', 'rel_posts', 'settings', 'theme', 'active', 'images', 'attributes'));
        }else{
            $s3 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug3)->where('categories.publish', 1)->where('categories.parent', $s2->id)->first();
            $category = $s4 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug4)->where('categories.publish', 1)->where('categories.parent', $s3->id)->first();
            if(isset($category)){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                if(!empty($set)){
                    $props1 = $set->property()->where('properties.expanded', 0)->orderBy('properties.order', 'ASC')->get();
                    $props2 = $set->property()->where('properties.expanded', 1)->orderBy('properties.order', 'ASC')->get();
                }else{
                    $props1 = null;
                    $props2 = null;
                }
                $topParent = PCategory::getTopParentBySlug($slug2);
                //$bred = Category::getBredcrumb($category->id);
                //$bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                //request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('min-price') ? $price[0] = request('max-price') : $price[0] = 0;
                request('max-price') ? $price[1] = request('max-price') : $price[1] = 0;
                request('min-promer') ? $promer[0] = request('min-promer') : $promer[0] = 0;
                request('max-promer') ? $promer[1] = request('max-promer') : $promer[1] = 0;
                request('min-water') ? $water[0] = request('min-water') : $water[0] = 0;
                request('max-water') ? $water[1] = request('max-water') : $water[1] = 0;
                request('sort') ? $sort = request('sort') : $sort = 2;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 9;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1], $promer[0], $promer[1], $water[0], $water[1]);
                //$properties = Property::getPropertiesAndAttributesByCategory($category->id);

                //$filteri = Product::getFiltersByCheckboxes($products);
                $filteri = Product::getFiltersByCategory($category->id);
                if($count > 0){
                    $oo = Property::sredi($filters);
                    $products = Product::filtered($products, $count, $limit, $sort, $oo);
                }else{
                    $products = Product::paginateRender($products, $limit, $sort);
                }
                $topCat = [];
                $max = Product::newMaxPrice($category->id, $filters);
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 's4', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props1', 'props2', 'max', 'set'));
            }else{
                return 'error 404';
            }
        }
    }

    public function shopCategory5($slug1, $slug2, $slug3, $slug4, $slug5)
    {
        $s1 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug1)->where('categories.publish', 1)->first();
        $s2 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug2)->where('categories.publish', 1)->where('categories.parent', $s1->id)->first();
        $s3 = $category = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug3)->where('categories.publish', 1)->where('categories.parent', $s2->id)->first();
        $product = Product::find($slug5);
        $theme = Theme::where('active', 1)->first();
        $settings = Setting::find(1);
        $active = $slug1;
        \Session::forget('filter');
        if($product){
            if(request('email') && request('news')){
                $newsletter = Newsletter::where('verification', request('news'))->first();
                $subscriber = Subscriber::where('verification', request('email'))->first();
                if(isset($newsletter) && isset($subscriber)){
                    Click::insertProductClick($newsletter->id, $product->id, $subscriber->id);
                }
            }
            $topParent = PCategory::getTopParentBySlug($slug1);
            $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();
            $related = Product::getRelatedByCategory($category->id, $product->id, 4);
            $rel_posts = array();
            $product->increment('views');
            $images = $product->images;
            $attributes = Attribute::getAttributesByProduct($product->id);
            $s4 = null;
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 's2', 's3', 's4', 's5', 'related', 'rel_posts', 'settings', 'theme', 'active', 'images', 'attributes'));
        }else{
            $s4 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug4)->where('categories.publish', 1)->where('categories.parent', $s3->id)->first();
            $category = $s5 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug5)->where('categories.publish', 1)->where('categories.parent', $s4->id)->first();
            if($category){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                if(!empty($set)){
                    $props1 = $set->property()->where('properties.expanded', 0)->orderBy('properties.order', 'ASC')->get();
                    $props2 = $set->property()->where('properties.expanded', 1)->orderBy('properties.order', 'ASC')->get();
                }else{
                    $props1 = null;
                    $props2 = null;
                }
                $topParent = PCategory::getTopParentBySlug($slug2);
                //$bred = Category::getBredcrumb($category->id);
                //$bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                //request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('min-price') ? $price[0] = request('max-price') : $price[0] = 0;
                request('max-price') ? $price[1] = request('max-price') : $price[1] = 0;
                request('min-promer') ? $promer[0] = request('min-promer') : $promer[0] = 0;
                request('max-promer') ? $promer[1] = request('max-promer') : $promer[1] = 0;
                request('min-water') ? $water[0] = request('min-water') : $water[0] = 0;
                request('max-water') ? $water[1] = request('max-water') : $water[1] = 0;
                request('sort') ? $sort = request('sort') : $sort = 2;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 9;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1], $promer[0], $promer[1], $water[0], $water[1]);
                //$properties = Property::getPropertiesAndAttributesByCategory($category->id);

                //$filteri = Product::getFiltersByCheckboxes($products);
                $filteri = Product::getFiltersByCategory($category->id);
                if($count > 0){
                    $oo = Property::sredi($filters);
                    $products = Product::filtered($products, $count, $limit, $sort, $oo);
                }else{
                    $products = Product::paginateRender($products, $limit, $sort);
                }
                $topCat = [];
                $max = Product::newMaxPrice($category->id, $filters);
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 's4', 's5', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props1', 'props2', 'max', 'set'));
            }else{
                return 'error 404';
            }
        }
    }

    public function shopCategory6($slug1, $slug2, $slug3, $slug4, $slug5, $slug6)
    {
        $s1 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug1)->where('categories.publish', 1)->first();
        $s2 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug2)->where('categories.publish', 1)->where('categories.parent', $s1->id)->first();
        $s3 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('slug', $slug3)->where('publish', 1)->where('parent', $s2->id)->first();
        $s4 = $category = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug4)->where('categories.publish', 1)->first();
        $product = Product::find($slug6);
        $theme = Theme::where('active', 1)->first();
        $settings = Setting::find(1);
        $active = $slug1;
        \Session::forget('filter');
        if(isset($product)){
            if(request('email') && request('news')){
                $newsletter = Newsletter::where('verification', request('news'))->first();
                $subscriber = Subscriber::where('verification', request('email'))->first();
                if(isset($newsletter) && isset($subscriber)){
                    Click::insertProductClick($newsletter->id, $product->id, $subscriber->id);
                }
            }
            $topParent = PCategory::getTopParentBySlug($slug1);
            $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();
            $related = Product::getRelatedByCategory($category->id, $product->id, 4);
            $rel_posts = array();
            $product->increment('views');
            $images = $product->images;
            $attributes = Attribute::getAttributesByProduct($product->id);
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 's2', 's3', 's4', 's5', 'related', 'rel_posts', 'settings', 'theme', 'active', 'images', 'attributes'));
        }else{
            $s5 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug5)->where('categories.publish', 1)->where('categories.parent', $s4->id)->first();
            $category = $s6 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug6)->where('categories.publish', 1)->where('categories.parent', $s5->id)->first();
            if(isset($category)){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                if(!empty($set)){
                    $props1 = $set->property()->where('properties.expanded', 0)->orderBy('properties.order', 'ASC')->get();
                    $props2 = $set->property()->where('properties.expanded', 1)->orderBy('properties.order', 'ASC')->get();
                }else{
                    $props1 = null;
                    $props2 = null;
                }
                $topParent = PCategory::getTopParentBySlug($slug2);
                //$bred = Category::getBredcrumb($category->id);
                //$bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                //request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('min-price') ? $price[0] = request('max-price') : $price[0] = 0;
                request('max-price') ? $price[1] = request('max-price') : $price[1] = 0;
                request('min-promer') ? $promer[0] = request('min-promer') : $promer[0] = 0;
                request('max-promer') ? $promer[1] = request('max-promer') : $promer[1] = 0;
                request('min-water') ? $water[0] = request('min-water') : $water[0] = 0;
                request('max-water') ? $water[1] = request('max-water') : $water[1] = 0;
                request('sort') ? $sort = request('sort') : $sort = 2;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 9;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1], $promer[0], $promer[1], $water[0], $water[1]);
                //$properties = Property::getPropertiesAndAttributesByCategory($category->id);

                //$filteri = Product::getFiltersByCheckboxes($products);
                $filteri = Product::getFiltersByCategory($category->id);
                if($count > 0){
                    $oo = Property::sredi($filters);
                    $products = Product::filtered($products, $count, $limit, $sort, $oo);
                }else{
                    $products = Product::paginateRender($products, $limit, $sort);
                }
                $topCat = [];
                $max = Product::newMaxPrice($category->id, $filters);
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 's4', 's5', 's6', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props1', 'props2', 'max', 'set'));
            }else{
                return 'error 404';
            }
        }
    }

    public function category($slug){
        $link = MenuLink::where('link', $slug)->first();
        if(!empty($link)){
            $active = $link->link;
            $settings = Setting::find(1);
            $theme = Theme::where('active', 1)->first();
            $category = PCategory::find($link->cat_id);
            $home = false;
            $watches = array();$watches2 = array();

            if($category->slug == 'tag-heuer'){
                $tag = Category::where('slug', $category->slug)->first();
                $children = Category::where('parent', $tag->id)->orderby('order', 'ASC')->get();
            }

            $bar11 = Category::find($category->cat1);
            if(count($bar11)){
                $bar1 = $bar11->product()->where('publish', 1)->where('amount', '>', 0)->orderByRaw("RAND()")->take(3)->get();
                if(count($bar1) > 0){
                    foreach($bar1 as $b){
                        $watches[] = $b;
                    }
                }
            }
            $watches = array_slice($watches, 0, 3);
            $bar22 = Category::find($category->cat2);
            if(count($bar22)){
                $bar2 = $bar22->product()->where('publish', 1)->where('amount', '>', 0)->orderByRaw("RAND()")->take(3)->get();
                if(count($bar2) > 0){
                    foreach($bar2 as $b){
                        $watches2[] = $b;
                    }
                }
            }
            $watches2 = array_slice($watches2, 0, 3);

            $posts = $category->post()->where('posts.publish', 1)->where('posts.publish_at', '<=', (new \Carbon\Carbon()))->orderby('posts.publish_at', 'DESC')->paginate(10);
            $topParent = null;
            $sliders = $category->post()->where('posts.publish', 1)->where('posts.publish_at', '<=', (new \Carbon\Carbon()))->orderby('posts.publish_at', 'DESC')->take(5)->get();

            if($category->id == 2){ $collections = Category::getCollections(5); }else{ $collections = []; }

            return view('themes.'.$theme->slug.'.pages.category', compact('posts', 'category', 'topParent', 'sliders', 'home', 'watches', 'watches2', 'theme', 'settings', 'children', 'collections', 'active'));
        }
        return 'error 404';
    }

    public function category2($slug1, $slug2){
        $link = MenuLink::where('link', $slug1.'/'.$slug2)->first();
        if(!empty($link)){
            $active = $slug1;
            $active2 = $slug1.'/'.$slug2;
            $settings = Setting::find(1);
            $theme = Theme::where('active', 1)->first();
            $category = PCategory::find($link->cat_id);
            $home = false;
            $watches = array();$watches2 = array();

            if($category->slug == 'tag-heuer'){
                $tag = Category::whereTranslation('slug', $category->slug)->first();
                $children = Category::where('parent', $tag->id)->orderby('order', 'ASC')->get();
            }

            $bar11 = Category::find($category->cat1);
            if(count($bar11)){
                $bar1 = $bar11->product()->where('publish', 1)->where('amount', '>', 0)->orderByRaw("RAND()")->take(3)->get();
                if(count($bar1) > 0){
                    foreach($bar1 as $b){
                        $watches[] = $b;
                    }
                }
            }
            $watches = array_slice($watches, 0, 3);
            $bar22 = Category::find($category->cat2);
            if(count($bar22)){
                $bar2 = $bar22->product()->where('publish', 1)->where('amount', '>', 0)->orderByRaw("RAND()")->take(3)->get();
                if(count($bar2) > 0){
                    foreach($bar2 as $b){
                        $watches2[] = $b;
                    }
                }
            }
            $watches2 = array_slice($watches2, 0, 3);

            $posts = $category->post()->where('posts.publish', 1)->where('posts.publish_at', '<=', (new \Carbon\Carbon()))->orderby('posts.publish_at', 'DESC')->paginate(10);
            $topParent = PCategory::getTopParent($category->id);
            $sliders = $category->post()->where('posts.publish', 1)->where('posts.publish_at', '<=', (new \Carbon\Carbon()))->orderby('posts.publish_at', 'DESC')->take(5)->get();

            if($category->id == 2){ $collections = Category::getCollections(5); }else{ $collections = []; }

            return view('themes.'.$theme->slug.'.pages.category', compact('posts', 'category', 'topParent', 'sliders', 'home', 'watches', 'watches2', 'theme', 'settings', 'children', 'collections', 'active', 'active2'));
        }
        return 'error 404';
    }

    public function more(){
        $cat = request('cat');
        $page = request('page');
        $category = PCategory::find($cat);
        if(isset($category)){
            $theme = Theme::where('active', 1)->first();
            $home = false;
            if($page > 1){ $ajax=true; }else{ $ajax=false; }
            $posts = $category->post()->where('publish', 1)->where('publish_at', '<=', (new \Carbon\Carbon()))->orderby('publish_at', 'DESC')->paginate(10);
            if(count($posts)){
                return view('themes.'.$theme->slug.'.partials.category-posts', compact('posts', 'category', 'home', 'ajax'));
            }else{
                return 'empty';
            }
        }else{
            return 'empty';
        }
    }

    public function search(){
        $text = request()->text;
        if(empty($text)){
            return redirect()->back()->with('error', 'Nismo razumeli Vašu pretragu');
        }else{
            $active = 'satovi';
            $settings = Setting::first();
            $theme = Theme::where('active', 1)->first();
            $products = Product::select('products.*')->where(function ($query) use ($text){
                $query->whereTranslationLike('title', '%'.$text.'%')->orWhereTranslationLike('slug', '%'.$text.'%')->orWhereTranslationLike('short', '%'.$text.'%')->orWhere('code', 'like', '%'.$text.'%');
            })->where('publish', 1)->orderBy('publish_at', 'DESC')->take(18)->get();
            /*$posts = Post::select('posts.*')->where(function ($query) use ($text){
                $query->whereTranslationLike('title', '%'.$text.'%')->orWhereTranslationLike('slug', '%'.$text.'%');
            })->where('publish', 1)->orderBy('publish_at', 'DESC')->take(18)->get();*/
            $home = true;
            return view('themes.'.$theme->slug.'.pages.search', compact('settings', 'theme', 'products', 'text', 'posts', 'home', 'active'));
        }
    }

    public function post($slug1, $slug2, $id){
        $post = Post::find($id);
        if(empty($post)) return 'error 404';
        $active = Post::getPostActiveLink($slug1);
        if($active == $slug1){
            $active2 = $active;
        }else{
            $active2 = $active.'/'.$slug1;
        }
        if(request('email') && request('news')){
            $newsletter = Newsletter::where('verification', request('news'))->first();
            $subscriber = Subscriber::where('verification', request('email'))->first();
            if(isset($newsletter) && isset($subscriber)){
                Click::insertPostClick($newsletter->id, $post->id, $subscriber->id);
            }
        }
        $pcategory = PCategory::whereTranslation('slug', $slug1)->first();
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $related = $pcategory->post()->where('posts.publish', 1)->where('posts.publish_at', '<=', (new \Carbon\Carbon()))->where('posts.id', '<>', $post->id)->orderBy('posts.publish_at', 'DESC')->paginate(3);
        $products = $post->product()->where('products.publish', 1)->inRandomOrder()->get();
        $tags = $post->tag()->get();
        return view('themes.'.$theme->slug.'.pages.post', compact('settings', 'theme', 'pcategory', 'post', 'related', 'products', 'active', 'active2', 'tags'));
    }

    public function post2($slug1, $slug2, $slug3, $id){
        $post = Post::find($id);
        if(empty($post)) return 'error 404';
        $active = Post::getPostActiveLink($slug1);
        if($active == $slug1){
            $active2 = $active.'/'.$slug2;
        }else{
            $active2 = $slug1.'/'.$slug2;
        }
        if(request('email') && request('news')){
            $newsletter = Newsletter::where('verification', request('news'))->first();
            $subscriber = Subscriber::where('verification', request('email'))->first();
            if(isset($newsletter) && isset($subscriber)){
                Click::insertPostClick($newsletter->id, $post->id, $subscriber->id);
            }
        }
        $pcategory = PCategory::whereTranslation('slug', $slug1)->first();
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $related = $pcategory->post()->where('posts.publish', 1)->where('posts.publish_at', '<=', (new \Carbon\Carbon()))->where('posts.id', '<>', $post->id)->orderBy('posts.publish_at', 'DESC')->paginate(3);
        $products = $post->product()->where('products.publish', 1)->inRandomOrder()->get();
        $tags = $post->tag()->get();
        return view('themes.'.$theme->slug.'.pages.post', compact('settings', 'theme', 'pcategory', 'post', 'related', 'products', 'active', 'active2', 'tags'));
    }

    public function attribute($slug, $id){
        $active = 'satovi';
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $attribute = $attribut = Attribute::find($id);
        $products = $attribute->product()->where('products.publish', 1)->orderBy('products.publish_at', 'DESC')->paginate(24);
        $home = true;
        return view('themes.'.$theme->slug.'.pages.attribute', compact('settings', 'theme', 'products', 'attribut', 'home', 'active'));
    }

    public function tags($slug, $id){
        $active = 'satovi';
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $tag = Tag::find($id);
        $posts = $tag->post()->where('posts.publish', 1)->orderBy('posts.publish_at', 'DESC')->paginate(24);
        $home = true;
        return view('themes.'.$theme->slug.'.pages.tag', compact('settings', 'theme', 'posts', 'tag', 'home', 'active'));
    }

    public function servis(){
        $active = 'satovi';
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $category = PCategory::whereTranslation('slug', 'info')->first();
        $topParent = PCategory::where('publish', 1)->where('order', '<>', 99)->orderby('order', 'ASC')->first();
        return view('themes.'.$theme->slug.'.pages.servis', compact('topParent', 'category', 'settings', 'theme', 'active'));
    }

    public function prodajna_mesta(){
        $active = 'satovi';
        $settings = Setting::find(1);
        $theme = Theme::where('active', 1)->first();
        $category = PCategory::whereTranslation('slug', 'info')->first();
        $topParent = PCategory::where('publish', 1)->where('order', '<>', 99)->orderby('order', 'ASC')->first();
        return view('themes.'.$theme->slug.'.pages.prodajna_mesta', compact('topParent', 'category', 'settings', 'theme', 'active'));
    }

    public function kontakt(){
        $active = 'satovi';
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $category = PCategory::whereTranslation('slug', 'info')->first();
        $topParent = PCategory::where('publish', 1)->where('order', '<>', 99)->orderby('order', 'ASC')->first();
        return view('themes.'.$theme->slug.'.pages.kontakt', compact('topParent', 'category', 'settings', 'theme', 'active'));
    }

    public function about(){
        $active = 'satovi';
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $category = PCategory::whereTranslation('slug', 'info')->first();
        $topParent = PCategory::where('publish', 1)->where('order', '<>', 99)->orderby('order', 'ASC')->first();
        return view('themes.'.$theme->slug.'.pages.about', compact('topParent', 'category', 'settings', 'theme', 'active'));
    }

    public function korpa(){
        $active = 'satovi';
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $category = PCategory::where('parent', 0)->where('order', '<>', 99)->where('publish', 1)->orderby('order', 'ASC')->first();
        $sum=0;
        return view('themes.'.$theme->slug.'.pages.cart', compact('category', 'sum', 'settings', 'theme', 'active', 'discount'));
    }

    public function kupovina(CartOrderRequest $request){
        //return request()->all();
        $theme = Theme::where('active', 1)->first();
        $customer = Customer::where('email', request('email'))->first();
        $user = User::where('email', request('email'))->first();

        if(empty($customer)) !empty($user)? $customer = $user->customer()->create(request()->all()) : $customer = Customer::create(request()->all());

        if(count(request('id'))==0) return back()->with('error', 'Došlo je do greške');

        if(request('newsletter')){
            $sub = Subscriber::where('email', request('email'))->first();
            if(empty($sub)){
                $sub = new Subscriber();
                $sub->email = request('email');
                $sub->verification = str_random(32);
                $sub->block = 0;
                $sub->save();
            }
        }

        $cart = new Cart();
        $cart->customer_id = $customer->id;
        $cart->payment_id = 1;
        $cart->status = 0;
        $cart->save();

        foreach (request('id') as $key1 => $id){
            foreach (request('col') as $key2 => $col){
                if($key1 == $key2){
                    for($i=0;$i<$col;$i++){
                        $cart->product()->attach($id);
                    }
                }
            }
        }

        $sum=0;
        foreach ($cart->product as $product){
            $sum += $product->price_small;
        }

        $cart->sum = $sum;
        $cart->update();

        \Session::forget('korpa');
        \Mail::to('nebojsart1409@yahoo.com')->queue(new OrderIsReadyMail($user, $theme, $cart));

        return redirect('/korpa')->with('done', 'Vaša narudžbina je izvršena!');

    }

    public function kontakt_form(SendKontaktFormRequest $request){
        return request()->all();
        $name = request('name');
        $lastname = request('lastname');
        $email = request('email');
        $poruka = request('message');
        $subject = 'Poruka sa sajta p-grupacija.hr';
        $settings = Setting::find(1);

        /*\Mail::send('emails.kontakt', [
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'poruka' => $poruka
        ], function($message) use ($subject) {
            $message->from('some@mail.com', 'Ime Prezime');
            $message->to('nebojsart1409@yahoo.com', 'Nebojša Marković')
                ->subject($subject);
        });*/

        \Mail::send('emails.kontakt', ['name' => $name, 'lastname' => $lastname, 'email' => $email, 'poruka' => $poruka], function($message) use ($subject, $name, $settings)
        {
            $message->to($settings->email1, $name)->subject($subject);
        });

        \Session::flash('message', 'Hvala na interesovanju. Odgovorićemo Vam u najkračem mogućem roku.');
        return redirect()->back();
    }

    public function removeProductFromCart($id){
        if(\Session::has('korpa') && count(\Session::get('korpa'))>0){
            $korpa = [];
            foreach (\Session::get('korpa') as $product){
                if($product != $id){
                    $korpa[] = $product;
                }
            }
            \Session::put('korpa', $korpa);
        }
        return 'done';
    }

    public function listakupovine(ListKupovineRequest $request){
        $ids = request('id');
        $cols = request('col');
        $products = array(); $sum=0;
        $theme = Theme::where('active', 1)->first();
        for($i=1;$i<=count($ids);$i++){
            $products[$i] = $p = Product::find($ids[$i]);
            $sum += $p->price_small*$cols[$i];
        }
        return view('themes.'.$theme->slug.'.partials.listakupovine_append', compact('products', 'cols', 'sum'));
    }

    public function mapa(){
        return view('pages.mapa');
    }

    public function subscribe(SubscribeRequest $request){
        $primary = Language::getPrimary();

        $sub = new Subscriber();
        $sub->language_id = $primary->id;
        $sub->email = request('email');
        $sub->name = request('name');
        $sub->verification = str_random(32);
        $sub->block = 0;
        $sub->save();
        return redirect()->back()->with('done', 'Uspešno ste se prijavili');
    }

    public function proba(){
        /*$array = [
            'radic.dejan.nbg@gmail.com',
            'dejan.radic@ministudio.rs',
            //'nebojsart1409@yahoo.com',
            //'nebojsa.markovic@ministudio.rs',
            'nenad@ministudio.rs',
            'nenad_bg@yahoo.com',
            'jova.sreco@ministudio.rs',
        ];
        foreach ($array as $email){
            \Mail::to($email)->send(new LuxLifeNewsletter());
        }

        return 'oprem';*/

        //return Product::cloneProduct(10, 1);
        //kopiranje atributa

        /*$products = Product::all();
        foreach ($products as $product){
            $product->price_small = rand(23,223);
            $product->update();
        }*/

//        $user = User::with('Customer')->where('email', 'nebojsa.markovic@ministudio.rs')->first();
//        $theme = Theme::where('active', 1)->first();
//        $cart = Cart::with('Product')->first();
//
//        \Mail::to('nebojsart1409@yahoo.com')->send(new OrderIsReadyMail($user, $theme, $cart));


//        $coupon = Coupon::getDiscount('xzRBfyby');
//        dd($coupon);

        //return $products = Property::join('property_translations', 'properties.id', '=', 'property_translations.property_id')->orderBy('properties.order', 'ASC')->pluck('property_translations.title', 'properties.id');
        //session()->forget('cart');
//        $product = Product::find(29);
//        return Product::getRelatedByColor($product);
        \Artisan::call('storage:link');
        return 'done2';
    }

    public function eleganza(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $hero = Block::find(4)->box()->where('publish', 1)->orderBy('order', 'ASC')->first();
        $home4 = Block::find(2)->box()->where('publish', 1)->orderBy('order', 'ASC')->get();
        $home1 = Block::find(3)->box()->where('publish', 1)->orderBy('order', 'ASC')->first();
        $posts = Post::where('publish', 1)->where('home', 1)->where('publish_at', '<=', (new \Carbon\Carbon()))->orderBy('publish_at', 'DESC')->take(3)->get();
        return view('themes.'.$theme->slug.'.pages.home', compact('settings', 'theme', 'hero', 'home4', 'home1', 'posts'));
    }

    public function eleganzaShop(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $category = Category::whereTranslation('slug', 'satovi')->first();
        $products = $category->product()->where('publish', 1)->where('publish_at', '<=', (new \Carbon\Carbon()))->orderBy('publish_at', 'DESC')->paginate(1);
        return view('themes.'.$theme->slug.'.pages.shop-category', compact('settings', 'theme', 'category', 'products'));
    }

    public function eleganzaBlog(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $posts = Post::select('posts.*')->join('p_category_post', 'posts.id', '=', 'p_category_post.post_id')->whereIn('p_category_post.p_category_id', PCategory::where('id', '<>', 3)->pluck('id'))
            ->groupBy('posts.id')->paginate(4);
        return view('themes.'.$theme->slug.'.pages.category', compact('settings', 'theme', 'posts'));
    }

    public function eleganzaWish(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.wishList', compact('settings', 'theme'));
    }

    public function eleganzaCart(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.cart', compact('settings', 'theme'));
    }

    public function eleganzaLogin(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.login', compact('settings', 'theme'));
    }

    public function eleganzaProduct(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.product', compact('settings', 'theme'));
    }

    public function eleganzaRegistration(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        return view('themes.'.$theme->slug.'.pages.registration', compact('settings', 'theme'));
    }

    public function wishList(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $cookie = Product::getCookie();
        count($cookie)>0? $products = Product::with('Brand')->whereIn('id', $cookie)->where('publish', 1)->get() : $products = [];
        return view('themes.'.$theme->slug.'.pages.wishList', compact('settings', 'theme', 'products'));
    }

    public function cart(){
        //return \Cart::content();
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        //$cart = session('cart');
        //count($cart)>0? $products = Product::with('Brand')->whereIn('id', Product::getCartIds())->where('publish', 1)->get() : $products = [];
        //$discount = \Session::has('discount')? \Session::get('discount') : 0;
        return view('themes.'.$theme->slug.'.pages.cart', compact('settings', 'theme', 'products', 'discount'));
    }

    public function cart2(){
        $settings = Setting::first();
        $theme = Theme::where('active', 1)->first();
        $cart = session('cart');
        count($cart)>0? $products = Product::with('Brand')->whereIn('id', Product::getCartIds())->where('publish', 1)->get() : $products = [];
        $discount = \Session::has('discount')? \Session::get('discount') : 0;
        return view('themes.'.$theme->slug.'.pages.cart2', compact('settings', 'theme', 'products', 'discount'));
    }

    public function addToWishList($id){
        return Product::addToWishList($id);
    }

    public function removeFromWishList($id){
        return Product::removeFromWishList($id);
    }

    public function addToCartFromWishList($id){
        Product::removeFromWishList($id);
        $product = Product::find($id);
        if(self::isExists($product) == false){
            $price = (float) $product->totalPrice;
            \Cart::add(['id' => $product->id, 'name' => $product->title, 'qty' => 1, 'price' => $price]);

            return response([
                'message' => 'done'
            ], 200);
        }
        return response([
            'message' => 'already exist'
        ], 422);
    }

    public function addToCart($id){
        //Product::addToCart($id);
        $product = Product::find($id);
        if(self::isExists($product) == false){
            $price = (float) $product->totalPrice;
            \Cart::add(['id' => $product->id, 'name' => $product->title, 'qty' => 1, 'price' => $price]);

            return response([
                'message' => 'done'
            ], 200);
        }
        return response([
            'message' => 'already exist'
        ], 422);
    }

    public function removeFromCart($id){
        //Product::removeFromCart($id);
        $product = Product::withoutGlobalScope('attribute')->find($id);
        if(!empty(\Cart::content())){
            foreach(\Cart::content() as $item){
                if($product->id == $item->id){
                    \Cart::remove($item->rowId);
                }
            }
        }
        return 'done';
    }

    public function getProductsFromCart(){
        $cart = session('cart');
        if(count($cart)>0){
            $products = Product::with('Brand')->whereIn('id', Product::getCartIds())->where('publish', 1)->get();
            $products->map(function($product){
                $product['checked'] = 0;
                $product['count'] = 1;

                return $product;
            });
        }else{
            $products = [];
        }

        return response()->json(['products' => $products], 200);
    }

    public function myOrders(){
        Product::removeFromCart();
        session()->forget('coupon');
        return 'moje narudzbine';
    }

    /**
     * @param $product
     * @return mixed
     */
    protected static function isExists($product){
        return \Cart::content()->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });
    }

}
