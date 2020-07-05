<?php

namespace App\Http\Controllers\Seller;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function index()
    {
        return view('seller/seller/index');
    }

    public function customerOrdersByTerm()
    {
        // $fromDate = date('Y-m-d H:i:s',strtotime(request('fromDate')));
        // $toDate = date('Y-m-d H:i:s',strtotime(request('toDate')));

        //// https://stackoverflow.com/questions/43871752/how-to-get-created-at-date-only-not-time-in-laravel-5-4
        $orders = Order::with('user','orderdetails')
                        ->whereDate('created_at', '>=', request('fromDate'))
                        ->whereDate('created_at', '<=', request('toDate'))
                        ->orderBy('created_at','desc')
                        ->get();

        // return $orders;

        return response()->json([
            'orders' => $orders,
        ]);

    }


    public function customerOrders()
    {
        $todayDate = date("Y-m-d");

        $orders = Order::with('user','orderdetails')
                        ->whereDate('created_at','=',$todayDate)
                        ->get();

        return response()->json([
                            'orders' => $orders,
        ]);

    }

    public function showCustomerOrders()
    {
        return view('seller.seller.showCustomerOrders');
    }
}
