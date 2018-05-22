<?php

namespace App;

use App\Traits\UploudableImageTrait;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use UploudableImageTrait;

    public static $list_limit = 50;

    protected $table = 'boxes';

    protected $fillable = ['block_id', 'title', 'subtitle', 'button', 'link', 'image', 'order', 'publish'];

    public static function getHttpLink($link){
        if(substr($link, 0, 4) == 'http'){
            return $link;
        }else{
            return url($link);
        }
    }

    public function block(){
        return $this->belongsTo(Block::class);
    }
}
