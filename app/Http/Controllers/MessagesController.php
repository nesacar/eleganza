<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Language;
use App\Message;
use Illuminate\Http\Request;
use File;

class MessagesController extends Controller
{
    public function __construct(){
        $this->middleware('menager', ['except' => ['add']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $slug = 'products';
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $messages = Message::orderBy('created_at', 'DESC')->paginate(50);
        return view('admin.messages.index', compact('slug', 'messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'products';
        return view('admin.messages.create', compact('slug'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMessageRequest $request)
    {
        $message = Message::create($request->all());
        $request->input('seen')? $message->seen = 1 : $message->seen = 0;
        $message->update();
        return redirect('admin/messages')->with('done', 'Poruka je kreirana');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(CreateMessageRequest $request)
    {
        $message = Message::create($request->all());
        $request->input('seen')? $message->seen = 1 : $message->seen = 0;
        $message->update();
        return 'done';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slug = 'products';
        $message = Message::find($id);
        return view('admin.messages.edit', compact('slug', 'message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(CreateMessageRequest $request, $id)
    {
        $message = Message::find($id);
        $message->update($request->all());
        $request->input('seen')? $message->seen = 1 : $message->seen = 0;
        $message->update();

        return redirect('admin/messages')->with('save', 'Poruka je izmenjena');
    }

    public function delete($id){
        Message::find($id)->delete();
        return redirect('admin/messages')->with('save', 'Poruka je obrisana');
    }
}
