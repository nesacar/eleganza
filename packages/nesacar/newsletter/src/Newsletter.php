<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['language_id', 'title', 'verification', 'received', 'last_send', 'types', 'numbers'];

    public static function getPostsIds($newsletter, $level){
        return self::join('newsletter_post', 'newsletters.id', '=', 'newsletter_post.newsletter_id')->join('posts', 'newsletter_post.post_id', '=', 'posts.id')
            ->where('newsletters.id', $newsletter->id)->where('newsletter_post.level', $level)->groupby('posts.id')->orderby('posts.created_at', 'DESC')->pluck('posts.id')->toArray();
    }

    public static function getPosts($newsletter, $level, $limit = false){
        if($limit){
            return self::select('posts.*')->join('newsletter_post', 'newsletters.id', '=', 'newsletter_post.newsletter_id')->join('posts', 'newsletter_post.post_id', '=', 'posts.id')
                ->where('newsletters.id', $newsletter->id)->where('newsletter_post.level', $level)->groupby('posts.id')->orderby('posts.created_at', 'DESC')->skip(1)->take($limit)->get();
        }else{
            return self::select('posts.*')->join('newsletter_post', 'newsletters.id', '=', 'newsletter_post.newsletter_id')->join('posts', 'newsletter_post.post_id', '=', 'posts.id')
                ->where('newsletters.id', $newsletter->id)->where('newsletter_post.level', $level)->groupby('posts.id')->orderby('posts.created_at', 'DESC')->get();
        }
    }

    public static function getPostLink($newsletter, $post, $sub){
        app()->setLocale($newsletter->locale);
        return Post::getPostLink($post) . '?email=' . $sub->verification . '&news=' . $newsletter->verification;
    }

    public static function setTemplate($types, $numbers){
        $niz = response()->json([
            'types' => $types,
            'numbers' => $numbers
        ]);
        return $niz;
    }

    public static function getInbetweenStrings($start, $end, $str){
        $matches = array();
        $regex = "/$start([a-zA-Z0-9_]*)$end/";
        preg_match_all($regex, $str, $matches);
        return $matches[1];
    }

    public function post(){
        return $this->belongsToMany(Post::class);
    }

    public function product(){
        return $this->belongsToMany(Product::class);
    }

    public function banner(){
        return $this->belongsToMany(Banner::class);
    }

    public function language(){
        return $this->belongsTo(Language::class);
    }
}
