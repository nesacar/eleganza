<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'keywords', 'desc', 'footer', 'address', 'course', 'phone1', 'phone2', 'email1', 'email2', 'facebook', 'twitter', 'instagram', 'google',
        'analytics', 'map', 'lang', 'colorDependence', 'materialDependence', 'newsletter', 'omot'
    ];

    public function language(){
        return $this->belongsTo(Language::class);
    }
}
