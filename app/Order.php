<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function orderdetails()
    {
        return $this->hasMany('App\Orderdetail')->with('product');
    }

    // public function user()
    // {
    //     return $this->belongsTo('App\User')->with('address');
    // }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function address()
    {
        return $this->belongsTo('App\Address');
    }
}
