<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Block;
use App\Box;
use App\Brand;
use App\Cart;
use App\Category;
use App\Click;
use App\Customer;
use App\Helper;
use App\Http\Requests\CartOrderRequest;
use App\Http\Requests\ListKupovineRequest;
use App\Http\Requests\SendKontaktFormRequest;
use App\Http\Requests\SubscribeRequest;
use App\Language;
use App\Mail\CartOrder;
use App\Mail\LuxLifeNewsletter;
use App\Menu;
use App\MenuLink;
use App\Newsletter;
use App\PCategory;
use App\Post;
use App\Product;
use App\Property;
use App\Set;
use App\Setting;
use App\Subscriber;
use App\Tag;
use App\Theme;
use App\User;
use Illuminate\Http\Request;

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
        $stock = Block::find(1)->box()->where('boxes.publish', 1)->orderBy('boxes.order', 'ASC')->get();
        $home = true;
        $active = 'satovi';
        $category = Menu::find(1)->menuLinks()->where('menu_links.parent', 0)->orderBy('menu_links.order', 'ASC')->first();
        $topParent = MenuLink::getTopParentBylink($category->link);
        $collections = Category::getCollections();
        $posts1 = Post::getHomeTwo();
        $posts2 = Post::getHomeTwoSkip();
        return view('themes.'.$theme->slug.'.pages.shop', compact('settings', 'theme', 'home', 'stock', 'category', 'topParent', 'active', 'collections', 'posts1', 'posts2'));
    }

    public function shopCategory($slug){
        \Session::forget('filter');
        $category = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug)->where('categories.publish', 1)->first();
        $s1 = $category;
        if(isset($category)){
            $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug)->first();
            $props = $set->property;
            $topParent = PCategory::getTopParentBySlug($slug);
            $bred = Category::getBredcrumb($category->id);
            $bred = array_reverse($bred);
            $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

            request('filters') ? $filters = request('filters') : $filters = [];
            request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
            request('sort') ? $sort = request('sort') : $sort = 1;
            request('page') ? $page = request('page') : $page = 1;
            request('limit') ? $limit = request('limit') : $limit = 20;

            $count = Property::countPropertyFilter($filters);
            $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1]);
            //$properties = Property::getPropertiesAndAttributesByCategory($category->id);

            $filteri = Product::getFiltersByCheckboxes($products);
            //$filteri = Product::getFiltersByCategory($category->id);
            if($count > 0){
                $oo = Property::sredi($filters);
                $products = Product::filtered($products, $count, $limit, $sort, $oo);
            }else{
                $products = Product::paginateRender($products, $limit, $sort);
            }

            $theme = Theme::where('active', 1)->first();
            $settings = Setting::find(1);
            $topCat = [];
            $active = $slug;
            return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props'));
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
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 'related', 'rel_posts', 'settings', 'active'));
        }else{
            $category = $s2;
            if(isset($category)){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                $props = $set->property;
                $topParent = PCategory::getTopParentBySlug($slug2);
                $bred = Category::getBredcrumb($category->id);
                $bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('sort') ? $sort = request('sort') : $sort = 1;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 20;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1]);
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
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props'));
            }else{
                return 'error 404';
            }
        }
    }


    public function shopCategory3($slug1, $slug2, $slug3)
    {
        $s1 = $category = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug1)->where('categories.publish', 1)->first();
        $s2 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug2)->where('categories.publish', 1)->where('categories.parent', $s1->id)->first();
        $s3 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug3)->where('categories.publish', 1)->where('categories.parent', $s2->id)->first();
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
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 's2', 's3', 'related', 'rel_posts', 'settings', 'theme', 'active'));
        }else{
            $category = $s3;
            if(isset($category)){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                $props = $set->property;
                $topParent = PCategory::getTopParentBySlug($slug2);
                $bred = Category::getBredcrumb($category->id);
                $bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('sort') ? $sort = request('sort') : $sort = 1;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 20;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1]);
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
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props'));
            }else{
                return 'error 404';
            }
        }
    }

    public function shopCategory4($slug1, $slug2, $slug3, $slug4)
    {
        $s1 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug1)->where('categories.publish', 1)->first();
        $s2 = $category = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug2)->where('categories.publish', 1)->where('categories.parent', $s1->id)->first();
        $s3 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug3)->where('categories.publish', 1)->where('categories.parent', $s2->id)->first();
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
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 's2', 's3', 's4', 's5', 'related', 'rel_posts', 'settings', 'theme', 'active'));
        }else{
            $category = $s4 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug4)->where('categories.publish', 1)->where('categories.parent', $s3->id)->first();
            if(isset($category)){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                $props = $set->property;
                $topParent = PCategory::getTopParentBySlug($slug2);
                $bred = Category::getBredcrumb($category->id);
                $bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('sort') ? $sort = request('sort') : $sort = 1;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 20;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1]);
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
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 's4', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props'));
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
        $s4 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug4)->where('categories.publish', 1)->where('categories.parent', $s3->id)->first();
        if(isset($s4)){
            $s5 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug5)->where('categories.publish', 1)->where('categories.parent', $s4->id)->first();
        }
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
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 's2', 's3', 's4', 's5', 'related', 'rel_posts', 'settings', 'theme', 'active'));
        }else{
            $category = $s5;
            if($category){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                $props = $set->property;
                $topParent = PCategory::getTopParentBySlug($slug2);
                $bred = Category::getBredcrumb($category->id);
                $bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('sort') ? $sort = request('sort') : $sort = 1;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 20;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1]);
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
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 's4', 's5', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props'));
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
        $s5 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.slug', $slug5)->where('categories.publish', 1)->where('categories.parent', $s4->id)->first();
        if(isset($s5)){
            $s6 = Category::select('categories.*')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.slug', $slug6)->where('categories.publish', 1)->where('categories.parent', $s5->id)->first();
        }
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
            return view('themes.'.$theme->slug.'.pages.product', compact('product', 'topParent', 'categories', 'category', 's1', 's2', 's3', 's4', 's5', 'related', 'rel_posts', 'settings', 'theme', 'active'));
        }else{
            $category = $s6;
            if(isset($category)){
                $set = Set::select('sets.*')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')->where('set_translations.slug', $slug1)->first();
                $props = $set->property;
                $topParent = PCategory::getTopParentBySlug($slug2);
                $bred = Category::getBredcrumb($category->id);
                $bred = array_reverse($bred);
                $categories = Category::where('level', $category->level)->where('publish', 1)->orderby('order', 'ASC')->get();

                request('filters') ? $filters = request('filters') : $filters = [];
                request('price') ? $price = (explode(",",request('price'))) : $price = (explode(",", "0,0"));
                request('sort') ? $sort = request('sort') : $sort = 1;
                request('page') ? $page = request('page') : $page = 1;
                request('limit') ? $limit = request('limit') : $limit = 20;

                $count = Property::countPropertyFilter($filters);
                $products = Product::filteredProducts($category->id, $filters, $sort, $price[0], $price[1]);
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
                return view('themes.'.$theme->slug.'.pages.shop-category', compact('category', 'topParent', 'bred', 'categories', 's1', 's2', 's3', 's4', 's5', 's6', 'products', 'filters', 'featured', 'settings', 'theme', 'topCat', 'active', 'filteri', 'props'));
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
            $topParent = PCategory::getTopParent($category->id);
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
            $posts = Post::select('posts.*')->where(function ($query) use ($text){
                $query->whereTranslationLike('title', '%'.$text.'%')->orWhereTranslationLike('slug', '%'.$text.'%');
            })->where('publish', 1)->orderBy('publish_at', 'DESC')->take(18)->get();
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
        return view('themes.'.$theme->slug.'.pages.cart', compact('category', 'sum', 'settings', 'theme', 'active'));
    }

    public function kupovina(CartOrderRequest $request){
        //return request()->all();
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
        \Mail::to('nebojsart1409@yahoo.com')->queue(new CartOrder($cart));

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
        $sub = new Subscriber();
        $sub->email = request('email');
        $sub->verification = str_random(32);
        $sub->block = 0;
        $sub->save();
        return redirect()->back()->with('done', 'Uspešno ste se prijavili');
    }

    public function proba(){
        //return Helper::getRandomImage('images/products');
        //return Helper::saveAllProperties('http://croatia.pggrupa.rs/proba');
        //return Helper::saveAllAttributes('http://croatia.pggrupa.rs/proba');
        //return Helper::saveAllBrands('http://croatia.pggrupa.rs/proba');
        //return Helper::saveAllCategories('http://croatia.pggrupa.rs/proba');
        //return Helper::saveAllPCategories('http://croatia.pggrupa.rs/proba');
        //return Helper::saveAllPosts('http://croatia.pggrupa.rs/proba');
        //return Helper::saveAllTags('http://croatia.pggrupa.rs/proba');
        //return Helper::saveAllProducts('http://croatia.pggrupa.rs/proba', 0);
        //return Helper::saveAllSets('http://croatia.pggrupa.rs/proba');
        //return Helper::fixCategoryParent();
        //return Helper::setPostTmbImage();
        //return Helper::setProductTmbImage();
        //return Helper::setCategoryCollectionImage();
        //return Product::getFiltersByCategory(101);
        //return Helper::saveSetsForProducts('http://croatia.pggrupa.rs/proba');
        //return $products = Product::where('code', null)->orWhere('code', '')->get();


        /*$boxes = Box::all();
        app()->setLocale('hr');
        if(count($boxes)>0){
            foreach ($boxes as $b){
                $b->title = $b->{'title:sr'};
                $b->subtitle = $b->{'subtitle:sr'};
                $b->button = $b->{'button:sr'};
                $b->link = $b->{'link:sr'};
                $b->update();
            }
        }*/

        /*return Attribute::select('properties.id', 'attribute_translations.title')
            ->join('attribute_translations', 'attributes.id', '=', 'attribute_translations.attribute_id')
            ->join('properties', 'attributes.property_id', '=', 'properties.id')
            ->join('property_translations', 'properties.id', '=', 'property_translations.property_id')
            ->groupBy('attributes.id')
            ->orderBy('attribute_translations.title', 'ASC')
            ->pluck('properties.id', 'attribute_translations.title');*/

        //\Session::put('korpa', [1728, 1727]);

        $array = [
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

        return 'oprem';
    }

    public function outlock(){
        $array = [
            'dejan.radic@ministudio.rs',
        ];
        foreach ($array as $email){
            \Mail::to($email)->send(new LuxLifeNewsletter());
        }

        return 'poslato na dejan.radic@ministudio.rs';
    }

    public function gmail(){
        $array = [
            'radic.dejan.nbg@gmail.com'
        ];
        foreach ($array as $email){
            \Mail::to($email)->send(new LuxLifeNewsletter());
        }

        return 'poslato na radic.dejan.nbg@gmail.com';
    }

    public function eleganza(){
        $settings = Setting::first();
        $theme = Theme::where('active', 0)->first();
        return view('themes.'.$theme->slug.'.pages.home', compact('settings', 'theme'));
    }

    public function eleganzaShop(){
        $settings = Setting::first();
        $theme = Theme::where('active', 0)->first();
        return view('themes.'.$theme->slug.'.pages.category', compact('settings', 'theme'));
    }

    public function eleganzaBlog(){
        $settings = Setting::first();
        $theme = Theme::where('active', 0)->first();
        return view('themes.'.$theme->slug.'.pages.blog', compact('settings', 'theme'));
    }

    public function eleganzaWish(){
        $settings = Setting::first();
        $theme = Theme::where('active', 0)->first();
        return view('themes.'.$theme->slug.'.pages.wishList', compact('settings', 'theme'));
    }

    public function eleganzaCart(){
        $settings = Setting::first();
        $theme = Theme::where('active', 0)->first();
        return view('themes.'.$theme->slug.'.pages.cart', compact('settings', 'theme'));
    }

    public function eleganzaLogin(){
        $settings = Setting::first();
        $theme = Theme::where('active', 0)->first();
        return view('themes.'.$theme->slug.'.pages.login', compact('settings', 'theme'));
    }

    public function eleganzaProduct(){
        $settings = Setting::first();
        $theme = Theme::where('active', 0)->first();
        return view('themes.'.$theme->slug.'.pages.product', compact('settings', 'theme'));
    }

    public function eleganzaRegistration(){
        $settings = Setting::first();
        $theme = Theme::where('active', 0)->first();
        return view('themes.'.$theme->slug.'.pages.registration', compact('settings', 'theme'));
    }

}
