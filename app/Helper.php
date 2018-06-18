<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;
use Ixudra\Curl\Facades\Curl;

class Helper extends Model
{
    public static function getRandomImage($directory){
        $files = File::allFiles($directory);
        $str = $files[array_rand($files, 1)];
        return str_replace('\\', '/', $str);
    }

    public static function saveAllProperties($url){
        app()->setLocale('sr');
        $res = Curl::to($url)->asJson()->get();
        $n=0; $o=0;
        if(!empty($res)){
            foreach ($res as $property){
                $old = Property::find($property->id);
                if(!empty($old)){
                    $old->title = $property->title;
                    $old->publish = $property->publish;
                    $old->update();
                    $o++;
                }else{
                    $new = new Property();
                    $new->id = $property->id;
                    $new->title = $property->title;
                    $new->publish = $property->publish;
                    $new->save();
                    $n++;
                }
            }
        }
        return 'Novih: ' . $n . ' | Starih: ' . $o;
    }

    public static function saveAllAttributes($url){
        app()->setLocale('sr');
        $res = Curl::to($url)->asJson()->get();
        $n=0; $o=0;

        if(!empty($res)){
            foreach ($res as $att){
                $old = Attribute::find($att->id);
                if(!empty($old)){
                    $old->property_id = $att->osobina_id;
                    $old->title = $att->title;
                    $old->publish = $att->publish;
                    $old->update();
                    $o++;
                }else{
                    $new = new Attribute();
                    $new->id = $att->id;
                    $new->property_id = $att->osobina_id;
                    $new->title = $att->title;
                    $new->publish = $att->publish;
                    $new->save();
                    $n++;
                }
            }
        }
        return 'Novih: ' . $n . ' | Starih: ' . $o;
    }

    public static function saveAllBrands($url){
        app()->setLocale('sr');
        $res = Curl::to($url)->asJson()->get();
        $n=0; $o=0;

        if(!empty($res)){
            foreach ($res as $brand){
                $old = Brand::find($brand->id);
                if(!empty($old)){
                    $old->title = $brand->title;
                    $old->publish = $brand->publish;
                    $old->update();
                    $o++;
                }else{
                    $new = new Brand();
                    $new->id = $brand->id;
                    $new->title = $brand->title;
                    $new->publish = $brand->publish;
                    $new->save();
                    $n++;
                }
            }
        }
        return 'Novih: ' . $n . ' | Starih: ' . $o;
    }

    public static function saveAllCategories($url){
        app()->setLocale('sr');
        $res = Curl::to($url)->asJson()->get();
        $n=0; $o=0;
        //dd($res);
        if(!empty($res)){
            foreach ($res as $category){
                $old = Category::find($category->id + 100);
                if(!empty($old)){
                    $old->parent = $category->parent + 100;
                    $old->order = $category->order;
                    $old->level = $category->level;
                    $old->title = $category->title;
                    $old->slug = str_slug($category->title);
                    $old->desc = $category->desc;
                    $old->image = $category->image;
                    $old->feature_image = $category->feature_image;
                    $old->collection = $category->collection;
                    $old->publish = $category->publish;
                    $old->update();
                    $o++;
                }else{
                    $new = new Category();
                    $new->id = $category->id + 100;
                    $new->parent = $category->parent + 100;
                    $new->order = $category->order;
                    $new->level = $category->level;
                    $new->title = $category->title;
                    $new->slug = str_slug($category->title);
                    $new->desc = $category->desc;
                    $new->image = $category->image;
                    $new->feature_image = $category->feature_image;
                    $new->collection = $category->collection;
                    $new->publish = $category->publish;
                    $new->save();
                    $n++;
                }
            }
        }
        return 'Novih: ' . $n . ' | Starih: ' . $o;
    }

    public static function saveAllPCategories($url){
        app()->setLocale('sr');
        $res = Curl::to($url)->asJson()->get();
        $n=0; $o=0;
        //dd($res);
        if(!empty($res)){
            foreach ($res as $category){
                $old = PCategory::find($category->id);
                if(!empty($old)){
                    $old->parent = $category->parent;
                    $old->order = $category->order;
                    $old->level = $category->level;
                    $old->title = $category->title;
                    $old->slug = str_slug($category->title);
                    $old->desc = $category->desc;
                    $old->image = $category->image;
                    $old->publish = $category->publish;
                    $old->update();
                    $o++;
                }else{
                    $new = new PCategory();
                    $new->id = $category->id;
                    $new->parent = $category->parent;
                    $new->order = $category->order;
                    $new->level = $category->level;
                    $new->title = $category->title;
                    $new->slug = str_slug($category->title);
                    $new->desc = $category->desc;
                    $new->image = $category->image;
                    $new->publish = $category->publish;
                    $new->save();
                    $n++;
                }
            }
        }
        return 'Novih: ' . $n . ' | Starih: ' . $o;
    }

    public static function saveAllPosts($url){
        app()->setLocale('sr');
        $res = Curl::to($url)->asJson()->get();
        $n=0; $o=0;
        //dd($res);
        if(!empty($res)){
            foreach ($res as $post){
                $old = Post::find($post->id);
                if(!empty($old)){
                    $old->user_id = $post->user_id;
                    $old->title = $post->title;
                    $old->slug = str_slug($post->title);
                    $old->short = $post->short;
                    $old->body = $post->body;
                    $old->image = $post->image;
                    $old->tmb = null;
                    $old->publish_at = $post->publish_at;
                    $old->publish = $post->publish;
                    $old->update();
                    $o++;

                    $old->pcategory()->sync($post->categories);
                }else{
                    $new = new Post();
                    $new->id = $post->id;
                    $new->user_id = $post->user_id;
                    $new->title = $post->title;
                    $new->slug = str_slug($post->title);
                    $new->short = $post->short;
                    $new->body = $post->body;
                    $new->image = $post->image;
                    $new->tmb = null;
                    $new->publish_at = $post->publish_at;
                    $new->publish = $post->publish;
                    $new->save();
                    $n++;

                    $new->pcategory()->sync($post->categories);
                }
            }
        }
        return 'Novih: ' . $n . ' | Starih: ' . $o;
    }

    public static function saveAllProducts($url, $skip=0){
        app()->setLocale('sr');
        $res = Curl::to($url)->withData(['skip' => $skip])->asJson()->get();
        $n=0; $o=0;
        //dd($res);
        if(!empty($res)){
            foreach ($res as $product){
                $old = Product::find($product->id);
                if(!empty($old)){
                    $old->user_id = 21;
                    $old->brand_id = $product->brend_id;
                    $old->code = $product->code;
                    $old->title = $product->title;
                    $old->slug = str_slug($product->title);
                    $old->short = $product->short;
                    $old->body = $product->body;
                    $old->body2 = $product->body2;
                    $old->image = $product->image;
                    $old->tmb = null;
                    $old->price_small = $product->price_small;
                    $old->price_outlet = $product->price;
                    $old->views = $product->views;
                    $old->amount = $product->amount;
                    $old->publish_at = $product->publish_at;
                    $old->publish = $product->publish;
                    $old->update();
                    $o++;

                    $categories = Category::add100($product->cats);
                    $old->category()->sync($categories);
                    $old->attribute()->sync($product->atts);
                    $old->post()->sync($product->posts);
                }else{
                    $new = new Product();
                    $new->id = $product->id;
                    $new->user_id = 21;
                    $new->brand_id = $product->brend_id;
                    $new->code = $product->code;
                    $new->title = $product->title;
                    $new->slug = str_slug($product->title);
                    $new->short = $product->short;
                    $new->body = $product->body;
                    $new->body2 = $product->body2;
                    $new->image = $product->image;
                    $new->tmb = null;
                    $new->price_small = $product->price_small;
                    $new->price_outlet = $product->price;
                    $new->views = $product->views;
                    $new->amount = $product->amount;
                    $new->publish_at = $product->publish_at;
                    $new->publish = $product->publish;
                    $new->save();
                    $n++;

                    $categories = Category::add100($product->cats);
                    $new->category()->sync($categories);
                    $new->attribute()->sync($product->atts);
                }
            }
        }
        return 'Novih: ' . $n . ' | Starih: ' . $o;
    }

    public static function saveAllSets($url){
        app()->setLocale('sr');
        $res = Curl::to($url)->asJson()->get();
        $n=0; $o=0;
        //dd($res);
        if(!empty($res)){
            foreach ($res as $set){
                $old = Set::find($set->id);
                if(!empty($old)){
                    $old->title = $set->title;
                    $old->publish = 1;
                    $old->update();
                    $o++;

                    $old->attribute()->sync($set->atts);
                    $old->property()->sync($set->props);
                }else{
                    $new = new Set();
                    $new->id = $set->id;
                    $new->title = $set->title;
                    $new->publish = 1;
                    $new->save();
                    $n++;

                    $new->attribute()->sync($set->atts);
                    $new->property()->sync($set->props);
                }
            }
        }
        return 'Novih: ' . $n . ' | Starih: ' . $o;
    }

    public static function saveAllTags($url){
        app()->setLocale('sr');
        $res = Curl::to($url)->asJson()->get();
        $n=0; $o=0;
        //dd($res);
        if(!empty($res)){
            foreach ($res as $tag){
                $old = Tag::find($tag->id);
                if(!empty($old)){
                    $old->title = $tag->name;
                    $old->slug = str_slug($tag->name);
                    $old->update();
                    $o++;

                    $old->post()->sync($tag->posts);
                }else{
                    $new = new Tag();
                    $new->id = $tag->id;
                    $new->title = $tag->name;
                    $new->slug = str_slug($tag->name);
                    $new->save();
                    $n++;

                    $new->post()->sync($tag->posts);
                }
            }
        }
        return 'Novih: ' . $n . ' | Starih: ' . $o;
    }

    public static function saveSetsForProducts($url){
        app()->setLocale('sr');
        $res = Curl::to($url)->asJson()->get();
        $o=0;
        //dd($res);
        if(!empty($res)){
            foreach ($res as $product){
                $old = Product::find($product->id);
                if(!empty($old)){
                    $old->set_id = $product->set_id;
                    $old->update();
                    $o++;
                }
            }
        }
        return 'Izmena: ' . $o;
    }

    public static function setPostTmbImage(){
        $posts = Post::all();
        if(count($posts)>0){
            foreach ($posts as $post){
                if($post->image != null && $post->image != ''){
                    $imagePathTmb = 'images/posts/tmb/' . $post->{"slug:sr"} . '-' . $post->id . '.' . File::extension($post->image);
                    File::copy($post->image, $imagePathTmb);

                    $post->tmb = $imagePathTmb;
                    $post->update();

                    $tmb = \Image::make($post->tmb);
                    $tmb->fit(1080, 500);
                    $tmb->save();
                }
            }
        }
        return 'done';
    }

    public static function setProductTmbImage($product=false){
        if($product){
            if($product->image != null && $product->image != ''){
                $imagePathTmb = 'images/products/tmb/' . $product->{"slug:hr"} . '-' . $product->id . '.' . File::extension($product->image);
                File::copy($product->image, $imagePathTmb);

                $product->tmb = $imagePathTmb;
                $product->update();

                $tmb = \Image::make($product->tmb);
                $tmb->fit(212, 307);
                $tmb->save();
            }
        }else{
            $products = Product::all();
            if(count($products)>0){
                foreach ($products as $product){
                    if($product->image != null && $product->image != ''){
                        $imagePathTmb = 'images/products/tmb/' . $product->{"slug:hr"} . '-' . $product->id . '.' . File::extension($product->image);
                        File::copy($product->image, $imagePathTmb);

                        $product->tmb = $imagePathTmb;
                        $product->update();

                        $tmb = \Image::make($product->tmb);
                        $tmb->fit(212, 307);
                        $tmb->save();
                    }
                }
            }
            return 'done';
        }
    }

    public static function setCategoryCollectionImage(){
        $categories = Category::where('collection', '<>', '')->get();
        if(count($categories)>0){
            foreach ($categories as $category){
                $imagePathTmb = 'images/categories/collection/' . $category->{"slug:sr"} . '-' . $category->id . '_collection.' . File::extension($category->collection);
                File::copy($category->collection, $imagePathTmb);

                $category->collection = $imagePathTmb;
                $category->update();

                $tmb = \Image::make($category->collection);
                $tmb->fit(208, 300);
                $tmb->save();
            }
        }
        return 'done';
    }

    public static function getExcelCategories($row){
        $res = [];
        if(!empty($row->cat1_id) && $row->cat1_id != 0) $res[] = $row->cat1_id;
        if(!empty($row->cat2_id) && $row->cat2_id != 0) $res[] = $row->cat2_id;
        if(!empty($row->cat3_id) && $row->cat3_id != 0) $res[] = $row->cat3_id;
        if(!empty($row->cat4_id) && $row->cat4_id != 0) $res[] = $row->cat4_id;
        return $res;
    }

    public static function getExcelAttributes($row){
        $res = [];
        for($i=0;$i<30;$i++){
            $str = 'id_att'.$i;
            if(!empty($row->$str) && $row->$str != 0) $res[] = $row->$str;
        }
        return $res;
    }

    public static function removeBrackets($str){
        return substr($str, 0, strpos($str, "("));
    }

}
