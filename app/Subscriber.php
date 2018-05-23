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

    protected $fillable = ['email', 'name', 'verification', 'block'];

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

    public static function filtered($email=false){
        return self::where(function ($query){
        })->where(function ($query) use ($email){
            if($email){
                $query->where('email', 'LIKE', '%' . $email . '%');
            }
        })->orderBy('created_at', 'DESC')->paginate(self::$list_limit);
    }

    public static function isAvailableEmail($email, $id){
        $sub = self::where('email', $email)->first();
        if(isset($sub)){
            if($sub->id == $id){
                return true;
            }else{
                return false;
            }
        }
        return true;
    }

}