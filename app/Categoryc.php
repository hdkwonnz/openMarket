<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoryc extends Model
{
    protected $guarded = [];

    public function categorya()
    {
        return $this->belongsTo('App\Categorya');
    }

    public function categoryb()
    {
        return $this->belongsTo('App\Categoryb');
    }
}
