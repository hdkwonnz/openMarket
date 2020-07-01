<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoryb extends Model
{
    protected $guarded = [];

    public function categorya()
    {
        return $this->belongsTo('App\Categorya');
    }

    public function categorycs()
    {
        return $this->hasMany('App\Categoryc');
    }
}
