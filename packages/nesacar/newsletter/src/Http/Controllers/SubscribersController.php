<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriberRequest;
use App\Http\Requests\EditAdminSusbcribersRequest;
use App\Http\Requests\EditSubscriberRequest;
use App\Language;
use App\Subscriber;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Input;

class SubscribersController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => ['subscribe', 'logout']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slug = 'subscribers';
        app()->setLocale('sr');
        $subscribers = Subscriber::filtered(Session::get('sub_language_id'), Session::get('sub_email'));
        $languages = Language::where('publish', 1)->orderBy('order', 'ASC')->pluck('name', 'id')->prepend('Svi jezici', 0);
        return view('admin.subscribers.index', compact('slug', 'subscribers', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'newsletters';
        $languages = Language::where('publish', 1)->orderBy('order', 'ASC')->get();
        return view('admin.subscribers.create', compact('slug', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSubscriberRequest $request)
    {
        Subscriber::createSubscriber($request);
        return redirect('admin/subscribers')->with('done', 'Pretplatnik je kreiran');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        $slug = 'newsletters';
        $languages = Language::where('publish', 1)->orderBy('order', 'ASC')->get();
        return view('admin.subscribers.edit', compact('slug', 'subscriber', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(EditSubscriberRequest $request, Subscriber $subscriber)
    {
        Subscriber::updateSubscriber($request, $subscriber);
        return redirect('admin/subscribers')->with('save', 'Pretplatnik je izmenjen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        //
    }

    public function delete($id){
        $sub = Subscriber::find($id);
        if(isset($sub)){
            $sub->delete();
        }
        return redirect('admin/subscribers')->with('save', 'Pretplatnik je obrisan');
    }

    public function subscribe(Request $request){
        $res = Subscriber::createSubscriber($request);
        return redirect()->back()->with('done', $res);
    }

    public function logout($verification){
        $sub = Subscriber::where('verification', $verification)->first();
        if(isset($sub)){
            $sub->block = 1;
            $sub->update();
            \Session::flash('done', 'Uspešno ste se odjavili sa naše Newsletter liste.');
        }else{
            \Session::flash('done', 'Uspešno ste se odjavili sa naše Newsletter liste.');
        }
    }

    public function search(Request $request){
        //return $request->all();
        \Session::put('sub_email', $request->input('text'));
        \Session::put('sub_language_id', $request->input('language_id'));
        return redirect('admin/subscribers');
    }

    public function publish($id){
        $val = Input::get('val');
        if($val == 'true'){ $primary = 1; }else{ $primary = 0; }
        $sub = Subscriber::find($id)->update(array('block' => $primary));
        if(isset($sub)){ return 'da'; }else{ return 'ne'; }
    }
}
