<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function __construct(){
        $this->middleware('menager', ['except' => ['create']]);
    }

    public function index(){
        $slug = 'products';
        $primary = Language::getPrimary();
        app()->setLocale($primary->locale);
        $messages = Message::orderBy('created_at', 'DESC')->paginate(50);
        return view('admin.messages.index', compact('slug', 'messages'));
    }

    public function create(CreateMessageRequest $request){
        $message = Message::create(request()->all());
        return 'done';
    }
}
