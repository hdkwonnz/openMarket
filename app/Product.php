<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function categorya()
    {
        return $this->belongsTo('App\Categorya');
    }

    public function categoryb()
    {
        return $this->belongsTo('App\Categoryb');
    }

    public function categoryc()
    {
        return $this->belongsTo('App\Categoryc');
    }

    public function orderdetails()
    {
    	return $this->hasMany('App\Orderdetail');
    }
}
