<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Click;
use App\Http\Requests\CreateNewsletterRequest;
use App\Http\Requests\PrepareNewsletterRequest;
use App\Language;
use App\Newsletter;
use App\Post;
use App\Product;
use App\Setting;
use App\Subscriber;
use App\Theme;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Jenssegers\Date\Date;
use Symfony\Component\Process\Process;
use DB;
use Illuminate\Container\Container;
use Illuminate\Mail\Markdown;

class NewslettersController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['logout', 'send']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Artisan::call('make:model', ['name' => 'Test']);
        //Artisan::call('queue:work', ['--timeout' => 60]);
        //Artisan::call('queue:restart');
        //Artisan::call('queue:listen', ['--timeout' => 60]);
        Date::setLocale('sr-SP');
        $slug = 'newsletters';
        $newsletters = Newsletter::paginate(50);
        return view('admin.newsletters.index', compact('newsletters', 'slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'newsletters';
        $languages = Language::where('publish', 1)->orderBy('order', 'ASC')->pluck('name', 'id');
        $setting = Setting::first();
        return view('admin.newsletters.prepare', compact('slug', 'languages', 'setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrepareNewsletterRequest $request)
    {
        $newsletter = Newsletter::create([
            'language_id' => $request->input('language_id'),
            'title' => $request->input('title'),
            'verification' => str_random(32),
            'types' => $request->input('types'),
            'numbers' => $request->input('numbers'),
            'received' => 0,
            'last_send' => null
        ]);
        if(count($request->input('products'))>0){
            $newsletter->product()->attach($request->input('products'));
        }
        if(count($request->input('banners'))>0){
            $newsletter->banner()->attach($request->input('banners'));
        }
        if(count($request->input('posts'))>0){
            $newsletter->post()->attach($request->input('posts'));
        }

        return redirect('admin/newsletters')->with('done', 'Newsletter je kreiran');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $newsletter)
    {
        $slug = 'newsletters';
        $languages = Language::where('publish', 1)->orderBy('order', 'ASC')->pluck('name', 'id');
        $setting = Setting::first();
        $language = Language::find($newsletter->language_id);
        if($setting->blog){
            $posts = Post::getPostSelect($language->locale);

            $postIds = $newsletter->post()->orderBy('newsletter_post.id', 'ASC')->get()->pluck('id');
        }
        if($setting->shop){
            $products = Product::getProductSelect($language->locale);
            $banners = Banner::getBannerSelect($language->locale);

            $productIds = $newsletter->product()->orderBy('newsletter_product.id', 'ASC')->get()->pluck('id');
            $bannerIds = $newsletter->banner()->orderBy('banner_newsletter.id', 'ASC')->get()->pluck('id');
        }
        $types = explode(',', $newsletter->types);
        $numbers = explode(',', $newsletter->numbers);
        return view('admin.newsletters.edit', compact('slug', 'languages', 'setting', 'newsletter', 'posts', 'banners', 'products', 'types', 'numbers', 'postIds', 'productIds', 'bannerIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function update(PrepareNewsletterRequest $request, $id)
    {
        $newsletter = Newsletter::find($id);
        $newsletter->update([
            'title' => $request->input('title')
        ]);
        if(count($request->input('products'))>0){
            $newsletter->product()->sync([]);
            $newsletter->product()->attach($request->input('products'));
        }
        if(count($request->input('banners'))>0){
            $newsletter->banner()->sync([]);
            $newsletter->banner()->attach($request->input('banners'));
        }
        if(count($request->input('posts'))>0){
            $newsletter->post()->sync([]);
            $newsletter->post()->attach($request->input('posts'));
        }

        return redirect('admin/newsletters/'.$newsletter->id.'/edit')->with('done', 'Newsletter je izmenjen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $newsletter)
    {
        //
    }

    public function delete($id){
        $news = Newsletter::find($id);
        $news->delete();
        return redirect('admin/newsletters')->with('done', 'Newsletter je obrisan.');
    }

    /*public function logout($verification){
        $sub = Subscriber::where('verification', $verification)->first();
        if(isset($sub)){
            $sub->block = 1;
            $sub->update();
            //Notification::subscriberLogout($sub->email);
            \Session::flash('done', 'Uspešno ste se odjavili sa naše Newsletter liste.');
        }
        return redirect('/');
    }*/

    /*public function preview($id){
        $theme = Theme::where('active', 1)->first();
        $newsletter = Newsletter::find($id);
        app()->setLocale($newsletter->locale);
        $sub = Subscriber::where('block', 0)->first();
        $preview = true;
        //$posts = $newsletter->post()->whereTranslation('locale', $newsletter->locale)->get();
        $markdown = Container::getInstance()->make(Markdown::class);
        return $markdown->render('admin.newsletters.preview', compact('newsletter', 'sub', 'preview', 'theme'));
    }*/

    public function post($n_veri, $post_id){
        $newsletter = Newsletter::where('verification', $n_veri)->first();
        $clicks = Click::getPostClicks($newsletter->id, $post_id);
        $post = Post::find($post_id);
        $banner=false;
        return view('admin.newsletters.clicks', compact('newsletter', 'banner', 'post', 'clicks'));
    }

    public function removePost(Request $request){
        $row = DB::table('newsletter_post')->where('newsletter_id', $request->input('newsletter'))->where('post_id', $request->input('post'))->first();
        if(isset($row)){
            $post = Post::find($request->input('post'));
            $post->newsletter()->detach([$request->input('newsletter')]);
            return 'yes';
        }else{
            return 'no';
        }
    }

    /*public function send($id){
        $theme = Theme::where('active', 1)->first();
        $newsletter = Newsletter::find($id);
        app()->setLocale($newsletter->locale);
        $subscribers = Subscriber::where('block', 0)->where('locale', $newsletter->locale)->orderby('created_at', 'ASC')->get();
        $brojac=0;
        if(count($subscribers)>0){
            foreach($subscribers as $s){
                $brojac++;
                $newsletter->increment('received');
                \Mail::to($s)->queue(new SendNewsletter2($newsletter, $s, $theme));
            }
            $newsletter->last_send = Carbon::now();
            $newsletter->update();
        }
        return redirect('admin/newsletters')->with('done', 'Newsletter je dat na slanje');

    }*/

    public function prepareUpdate(PrepareNewsletterRequest $request){
        $setting = Setting::first();
        $locale = $request->input('language_id');
        $language = Language::find($locale);
        $posts = []; $banners = []; $products = [];
        if($setting->blog){
            $posts = Post::getPostSelect($language->locale);
        }
        if($setting->shop){
            $products = Product::getProductSelect($language->locale);
            $banners = Banner::getBannerSelect($language->locale);
        }
        $tt = $request->input('type');
        $nn = $request->input('number');
        $title = $request->input('title');
        $types = [];
        $numbers = [];
        for($i=0;$i<count($tt);$i++){
            if($tt[$i] > 0 && $nn[$i] != null){
                $types[] = $tt[$i];
                $numbers[] = $nn[$i];
            }
        }
        $typeString = implode(',',$types);
        $numberString = implode(',',$numbers);
        return view('admin.newsletters.create', compact('language', 'posts', 'products', 'banners', 'types', 'numbers', 'title', 'typeString', 'numberString'));
    }

}
