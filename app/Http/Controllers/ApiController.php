<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Brand;
use App\Category;
use App\Language;
use App\Product;
use App\Property;
use App\Set;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function brands(){
        $primary = Language::getPrimary();
        $brands = Brand::select('brands.id', 'brand_translations.title')->join('brand_translations', 'brands.id', '=', 'brand_translations.brand_id')
            ->where('brands.publish', 1)->where('brand_translations.locale', $primary->locale)->groupBy('brands.id')->orderBy('brands.id', 'ASC')->get();
        return response()->json([
            'brands' => $brands
        ], 200);
    }

    public function sets(){
        $primary = Language::getPrimary();
        $sets = Set::select('sets.id', 'set_translations.title')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')
            ->where('sets.publish', 1)->where('set_translations.locale', $primary->locale)->groupBy('sets.id')->orderBy('sets.id', 'ASC')->get();
        return response()->json([
            'sets' => $sets
        ], 200);
    }

    public function locales(){
        $locales = Language::select('id', 'locale as title')->where('publish', 1)->orderBy('order', 'ASC')->get();
        return response()->json([
            'locales' => $locales
        ], 200);
    }

    public function categories(){
        $primary = Language::getPrimary();
        if(request('category_id')>0){
            $categories = Category::select('categories.id', 'category_translations.title')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('categories.publish', 1)->where('category_translations.locale', $primary->locale)->where('categories.level', request('level'))->where('categories.parent', request('category_id'))
                ->groupBy('categories.id')->orderBy('categories.order', 'ASC')->get();
        }else{
            $categories = Category::select('categories.id', 'category_translations.title')->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('categories.publish', 1)->where('category_translations.locale', $primary->locale)->where('categories.level', request('level'))
                ->groupBy('categories.id')->orderBy('categories.order', 'ASC')->get()->reverse();
        }

        return response()->json([
            'categories' => $categories
        ], 200);
    }

    public function properties(){
        $primary = Language::getPrimary();
        if(request('set_id') == 0){
            $properties = Property::select('properties.id', 'property_translations.title', 'set_translations.title as set_title')
                ->join('property_translations', 'properties.id', '=', 'property_translations.property_id')->join('property_set', 'properties.id', '=', 'property_set.property_id')
                ->join('sets', 'property_set.set_id', '=', 'sets.id')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')
                ->where('properties.publish', 1)->where('property_translations.locale', $primary->locale)->where('set_translations.locale', $primary->locale)
                ->groupBy('properties.id')->orderBy('property_translations.title', 'ASC')->get();
        }else{
            $properties = Property::select('properties.id', 'property_translations.title', 'set_translations.title as set_title')
                ->join('property_translations', 'properties.id', '=', 'property_translations.property_id')->join('property_set', 'properties.id', '=', 'property_set.property_id')
                ->join('sets', 'property_set.set_id', '=', 'sets.id')->join('set_translations', 'sets.id', '=', 'set_translations.set_id')
                ->where('properties.publish', 1)->where('property_translations.locale', $primary->locale)->where('set_translations.locale', $primary->locale)->where('sets.id', request('set_id'))
                ->groupBy('properties.id')->orderBy('set_translations.title', 'ASC')->get();
        }
        return response()->json([
            'properties' => $properties
        ], 200);
    }

    public function attributes(){
        $primary = Language::getPrimary();
        $attributes = Attribute::select('attributes.id', 'attribute_translations.title')
            ->join('attribute_translations', 'attributes.id', '=', 'attribute_translations.attribute_id')
            ->where('attributes.publish', 1)->where('attribute_translations.locale', $primary->locale)->where('attributes.property_id', request('property_id'))
            ->groupBy('attributes.id')->orderBy('attribute_translations.title', 'ASC')->get();
        return response()->json([
            'attributes' => $attributes
        ], 200);
    }

    public function saveProducts(){
        //return request()->all();
        $br=0;
        if(count(request('products'))>0){
            foreach (request('products') as $product){
                if(!empty($product['code'])){
                    $language = Language::find($product['language_id']);
                    app()->setLocale($language['locale']);

                    $old = Product::where('code', $product['code'])->first();
                    if(!empty($old)){
                        $old->brand_id = $product['brand_id'];
                        $old->set_id = $product['set_id'];
                        $old->title = $product['title'];
                        $old->slug = str_slug($product['title']);
                        $old->code = $product['code'];
                        $old->short = $product['short'];
                        $old->body = $product['body'];
                        $old->publish = $product['publish'];
                        $old->publish_at = Carbon::parse($product['publish_at']);
                        $old->amount = $product['amount'];
                        $old->price_small = $product['price_small'];
                        $old->discount = $product['discount'];
                        $old->price_outlet = Product::calculateDiscount($product['discount'], $old);
                        $old->update();

                        if(!empty($product['image'])){
                            Product::base64UploadImage($old->id, $product['image']);
                        }

                        $cats = Category::prepareCategoryFromVueExcelTable($product['cat1_id'], $product['cat2_id'], $product['cat3_id'], $product['cat4_id']);
                        $atts = Attribute::prepareAttributeFromVueExcelTable($product['att1_id'], $product['att2_id'], $product['att3_id'], $product['att4_id'], $product['att5_id'], $product['att6_id'], $product['att7_id'], $product['att8_id']);


                        $old->attribute()->sync($atts);
                        $old->category()->sync($cats);
                    }else{
                        $new = new Product();
                        $new->brand_id = $product['brand_id'];
                        $new->set_id = $product['set_id'];
                        $new->title = $product['title'];
                        $new->slug = str_slug($product['title']);
                        $new->code = $product['code'];
                        $new->short = $product['short'];
                        $new->body = $product['body'];
                        $new->publish = $product['publish'];
                        $new->publish_at = Carbon::parse($product['publish_at']);
                        $new->amount = $product['amount'];
                        $new->price_small = $product['price_small'];
                        $new->price_outlet = $product['price_outlet'];
                        $new->discount = $product['discount'];
                        $new->save();

                        if(!empty($product['image'])){
                            Product::base64UploadImage($new->id, $product['image']);
                        }

                        $new->price_outlet = Product::calculateDiscount($product['discount'], $new);
                        $new->update();

                        $cats = Category::prepareCategoryFromVueExcelTable($product['cat1_id'], $product['cat2_id'], $product['cat3_id'], $product['cat4_id']);
                        $atts = Attribute::prepareAttributeFromVueExcelTable($product['att1_id'], $product['att2_id'], $product['att3_id'], $product['att4_id'], $product['att5_id'], $product['att6_id'], $product['att7_id'], $product['att8_id']);


                        $new->attribute()->sync($atts);
                        $new->category()->sync($cats);
                    }

                    $br++;
                }else{
                    return 'nema sifre';
                }
            }
        }
        return response()->json(['msg' => $br], 200);
    }
}
