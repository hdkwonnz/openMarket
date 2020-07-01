<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorya extends Model
{
    protected $guarded = [];

    public function categorybs()
    {
        return $this->hasMany('App\Categoryb');
    }

    public function categorycs()
    {
        return $this->hasMany('App\Categoryc');
    }
}
