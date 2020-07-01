<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }
}
