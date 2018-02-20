<?php

namespace App;

use FontLib\Table\Type\loca;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Session;

class Subscriber extends Model
{
    public static $list_limit = 50;

    protected $table = 'subscribers';

    protected $fillable = ['language_id', 'email', 'verification', 'block'];

    public static function createSubscriber(Request $request){
        $sub = self::where('email', $request->input('email'))->first();
        if(!isset($sub)){
            $sub = self::create($request->all());
            $sub->verification = str_random(16);
            $sub->block = 0;
            $sub->update();
            return 'Uspešno ste se prijavili na našu Newsletter listu.';
        }
        return 'Već ste prijavljeni na našu Newsletter listu.';
    }

    public static function updateSubscriber(Request $request, $sub){
        $sub->update($request->all());
        if($sub->verification == null){ $sub->verification = str_random(16); }
        $request->input('block')? $sub->block = 1 : $sub->block = 0;
        $sub->update();
    }

    public static function filtered($locale=0, $email=false){
        return self::where(function ($query) use ($locale){
            if($locale != 0){
                $query->where('language_id', $locale);
            }
        })->where(function ($query) use ($email){
            if($email){
                $query->where('email', 'LIKE', '%' . $email . '%');
            }
        })->orderBy('created_at', 'DESC')->paginate(self::$list_limit);
    }

    public function language(){
        return $this->belongsTo(Language::class);
    }

}