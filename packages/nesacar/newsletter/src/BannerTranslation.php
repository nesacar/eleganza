<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerTranslation extends Model
{
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banner_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'link', 'image'];
}
