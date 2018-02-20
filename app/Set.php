<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Set extends Model {

    use Translatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'slug'];

    protected $fillable = ['id', 'publish'];

    /**
     * Get a list of asortimen associated with the current brend.
     *
     * @var array
     */
    public function getAsortimanListAttribute(){
        return $this->asortiman->lists('id');
    }

    /**
     * Get a list of brends associated with the current asortiman.
     *
     * @var array
     */
    public function getBrandListAttribute(){
        return $this->brand->lists('id');
    }

    public static function getAtt($id){
        $set = Set::find($id);
        $niz = $set->attribute()->pluck('attributes.id')->toArray();
        $osobinas = $set->property()->where('properties.publish', 1)->get();
        $str="";
        if(isset($osobinas)){
            foreach($osobinas as $o){
                $str .=  "<div class='col-sm-3'><ul>";
                $str .=  "<li>".$o->{'title:sr'}."</li>";
                if($o->attribute){
                    $str .=  "<ul>";
                    foreach($o->attribute as $a){
                        $str .= "<li><input type='checkbox' name='atts[]' value='{$a->id}'";
                        if(in_array($a->id, $niz)){
                            $str .= 'checked';
                        }
                        $str .=  ">".$a->{'title:sr'}."</li>";
                    }
                    $str .= "</ul>";
                }
                $str .= "</div></ul>";
            }
        }
        return $str;
    }

    public function product(){
        return $this->hasMany('App\Product');
    }

    public function attribute(){
        return $this->belongsToMany('App\Attribute');
    }

    public function property(){
        return $this->belongsToMany('App\Property');
    }

}
