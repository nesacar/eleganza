<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model {

    protected $table = 'newsletters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['language_id', 'title', 'verification', 'received', 'send', 'skip', 'last_send', 'active'];

    public static function sendNewsletter($newsletter_id, $group_id){
        $theme = Theme::where('active', 1)->first();
        $newsletter = self::find($newsletter_id);
        $group = Group::find($group_id);
        if($group_id == 0){
            $subscribers = Subscriber::where('block', 0)->get();
        }else{
            $subscribers = $group->subscriber()->where('block', 0)->get();
        }
        if(count($subscribers)){
            foreach($subscribers as $s){
                \Mail::send('themes.'.$theme->slug.'.newsletters.newsletter-'.$newsletter->template_id, ['newsletter' => $newsletter, 'sub' => $s, 'preview' => false], function($message) use ($s, $newsletter)
                {
                    $message->to($s->email)->subject($newsletter->title);
                });
            }
        }
        $newsletter->send = 1;
        $newsletter->last_send = \Carbon\Carbon::now();
        $newsletter->received = $newsletter->received + count($subscribers);
        $newsletter->update();
    }

    public static function prepareNewsletter($newsletter){
        $array = [];
        $posts = $newsletter->post;
        if(count($posts)>0){
            for($i=0;$i<count($posts);$i++){
                $array['posts'][] = $posts[$i];
                $array['products'.$i] = $newsletter->product()->skip($i)->take(3)->get();
            }
        }
        return $array;
    }

    public static function getPostLink($newsletter, $post, $sub){
        app()->setLocale($newsletter->language->locale);
        return Post::getPostLink($post) . '?email=' . $sub->verification . '&news=' . $newsletter->verification;
    }

    public static function getProductLink($newsletter, $product, $sub){
        app()->setLocale($newsletter->language->locale);
        return url(Product::getProductLink($product->id)) . '?email=' . $sub->verification . '&news=' . $newsletter->verification;
    }

    public function product(){
        return $this->belongsToMany('App\Product');
    }

    public function post(){
        return $this->belongsToMany('App\Post');
    }

    public function template(){
        return $this->belongsTo('App\Newsletter_template');
    }

    public function subscriber(){
        return $this->belongsToMany('App\Subscriber');
    }

    public function banner(){
        return $this->belongsToMany('App\Banner');
    }

    public function language(){
        return $this->belongsTo('App\Language');
    }

}
