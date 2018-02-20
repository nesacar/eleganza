<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Click extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clicks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['newsletter_id', 'post_id', 'product_id', 'subscriber_id'];

    public static function insertPostClick($newsletter_id, $post_id, $subscriber_id){
        $click = new Click();
        $click->post_id = $post_id;
        $click->newsletter_id = $newsletter_id;
        $click->subscriber_id = $subscriber_id;
        $click->save();
    }

    public static function insertProductClick($newsletter_id, $product_id, $subscriber_id){
        $click = new Click();
        $click->product_id = $product_id;
        $click->newsletter_id = $newsletter_id;
        $click->subscriber_id = $subscriber_id;
        $click->save();
    }

    public static function getPostClicks($newsletter_id, $post_id){
        return self::select('*', DB::raw('COUNT(*) as click', 'subscribers.email as email'))
            ->join('subscribers', 'clicks.subscriber_id', '=', 'subscribers.id')
            ->where('clicks.post_id', $post_id)->where('clicks.newsletter_id', $newsletter_id)
            ->groupby('clicks.subscriber_id')->orderbyRaw('click DESC')
            ->paginate(50);
    }

    public static function getPostClicksCount($newsletter_id, $post_id){
        return self::select('clicks.*')
            ->join('subscribers', 'clicks.subscriber_id', '=', 'subscribers.id')
            ->where('clicks.post_id', $post_id)->where('clicks.newsletter_id', $newsletter_id)
            ->groupby('clicks.subscriber_id')->count();
    }

    public static function getProductClicks($newsletter_id, $product_id){
        return self::select('*', DB::raw('COUNT(*) as click', 'subscribers.email as email'))
            ->join('subscribers', 'clicks.subscriber_id', '=', 'subscribers.id')
            ->where('clicks.product_id', $product_id)->where('clicks.newsletter_id', $newsletter_id)
            ->groupby('clicks.subscriber_id')->orderbyRaw('click DESC')
            ->paginate(50);
    }

    public static function getProductClicksCount($newsletter_id, $product_id){
        return self::select('clicks.*')
            ->join('subscribers', 'clicks.subscriber_id', '=', 'subscribers.id')
            ->where('clicks.product_id', $product_id)->where('clicks.newsletter_id', $newsletter_id)
            ->groupby('clicks.subscriber_id')->count();
    }
}
