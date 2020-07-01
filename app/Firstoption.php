<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firstoption extends Model
{
    protected $guarded = [];

    public function secondoptions()
    {
        return $this->belongsToMany('App\Secondoption')->orderBy('description','asc')->withTimestamps();
    }
}
