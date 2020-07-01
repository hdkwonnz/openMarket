<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use App\Cart;
use App\Order;
use App\Orderdetail;
use DateTime;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function payment(Request $request)
    {
        if (!Session::has('cart')){
            return response()->json([
                'errorMsg' => "No session exits.",
            ]);
        }

        $oldCart = Session::get('cart');

        $cart = new Cart($oldCart);

        //$count = $cart->countOfItems;

        // return $cart->items;

        $totalPrice = 0;
        foreach($cart->items as $item){
            $totalPrice += $item['qty'] * $item['price'];
        }

        $totalSalePrice = 0;
        foreach($cart->items as $item){
            $totalSalePrice += $item['qty'] * $item['salePrice'];
        }

        $products = $cart->items;

        DB::beginTransaction();

        try{
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'total_amount' => $totalSalePrice,
                'shipping_cost' => 10,
                'delivery_address' => '7 tinturn pl. flat bush auckland',
                'addressee' => 'Leo Kwon',
                'shipping_date' => new DateTime(),
            ]);

            foreach ($products as $product){
                Orderdetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product['productId'],
                    'price' => $product['price'],
                    'sale_price' => $product['salePrice'],
                    'qty' => $product['qty'],
                ]);
            }

            DB::commit();

            session()->forget('cart');

            ////https://stackoverflow.com/questions/30019627/redirectroute-with-parameter-in-url-in-laravel-5
            // return \Redirect::route('order.orderDetailsById', [$order->id]);

            return response()->json([
                'orderId' => $order->id,
            ]);
        }
        catch(Exception $e){

            DB::rollback();

            return response()->json([
                'errorMsg' => 'woops! data base errors on orders & orderdetails table.',
            ]);
        }
    }

    public function checkOut()
    {
        if (!Session::has('cart')){
            $errorMsg = "No items to check out.";
            return view('checkout.checkOut', compact('errorMsg'));
        }

        $oldCart = Session::get('cart');

        $cart = new Cart($oldCart);

        $count = $cart->countOfItems;

        // return $cart->items;

        $totalPrice = 0;
        foreach($cart->items as $item){
            $totalPrice += $item['qty'] * $item['price'];
        }

        $totalSalePrice = 0;
        foreach($cart->items as $item){
            $totalSalePrice += $item['qty'] * $item['salePrice'];
        }

        return view('checkout.checkOut',['products' => $cart->items,'totalPrice' => $totalPrice,
                                      'totalSalePrice' => $totalSalePrice, 'count' => $count,
                                      'errorMsg' => null]);
    }
}
