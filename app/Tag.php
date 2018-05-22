<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{

    public static $list_limit = 50;

    protected $table = 'tags';

    protected $fillable = ['title', 'slug'];

    public static function addTags(array $tags){
        for($i=0;$i<count($tags);$i++){
            $tag = self::select('tags.id as id')->where('tags.id', $tags[$i])->first();
            if(!isset($tag)){
                $ta = new Tag;
                $ta->title = $tags[$i];
                $ta->slug = Str::slug($tags[$i]);
                $ta->save();

                $tags = array_diff($tags, [$tags[$i]]);
                $tags[$i] = (string)$ta->id;
                //$ta->translate($locale)->title = $tags[$i];
                //$ta->translate($locale)->slug = Str::slug($tags[$i]);
            }else{
                $tags[$i] = (string)$tag->id;
            }
        }
        return $tags;
    }

    public function post(){
        return $this->belongsToMany(Post::class);
    }
}
