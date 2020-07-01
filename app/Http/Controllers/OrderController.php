<?php

namespace App\Http\Controllers;

use Session;
use App\Cart;
use App\Order;
use App\Orderdetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orderDetails()
    {

        return view('order.orderDetails');
    }

    public function getOrderDetails()
    {
        $yymmddhis = date("Y-m-d H:i:s", strtotime("-1 months"));  //한달전 yymmddhis

        $orders = Order::with('orderdetails')
                        ->where('user_id','=',auth()->user()->id)
                        ->where('created_at', '>=', $yymmddhis)
                        ->get();

        // return $orders;

        return response()->json([
            'orders' => $orders,
        ]);
    }

    public function orderDetailsById($id)
    {
        $orders = Order::with('orderdetails')
                        ->where('user_id','=',auth()->user()->id)
                        ->where('id','=',$id)
                        ->get();

        // return $orders;

        return view('order.orderDetailsById', compact('orders'));
    }

    // public function orderDetails()
    // {

    //     $orders = Order::with('orderdetails')
    //                     ->where('user_id','=',auth()->user()->id)
    //                     ->get();

    //     // return $orders;

    //     return view('order.orderDetails', compact('orders'));
    // }

    public function orderDetailsByTerm()
    {
        // $fromDate = date('Y-m-d H:i:s',strtotime(request('fromDate')));
        // $toDate = date('Y-m-d H:i:s',strtotime(request('toDate')));

        //// https://stackoverflow.com/questions/43871752/how-to-get-created-at-date-only-not-time-in-laravel-5-4
        $orders = Order::with('orderdetails')
                        ->where('user_id','=',auth()->user()->id)
                        ->whereDate('created_at', '>=', request('fromDate'))
                        ->whereDate('created_at', '<=', request('toDate'))
                        ->get();

        // return $orders;

        return response()->json([
            'orders' => $orders,
        ]);
    }
}
