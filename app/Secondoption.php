<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secondoption extends Model
{
    protected $guarded = [];

    public function firstoptions()
    {
        return $this->belongsToMany('App\Firstoption')->withTimestamps();
    }
}
