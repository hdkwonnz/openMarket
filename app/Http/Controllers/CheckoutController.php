<?php

namespace App\Http\Controllers;

use Session;
use App\Cart;
use DateTime;
use App\Order;
use Stripe\Stripe;
use App\Orderdetail;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function payment(Request $request)
    {
        if (!Session::has('cart')){
            return response()->json([
                                        'errorMsg' => "Unable to checkout due to cart session already deleted.",
                                    ]);
        }

        ////payNow.blade.php => body: JSON.stringify({paymentIntent: paymentIntent})로 넘어 왔기 때문에...
        $data = $request->json()->all();

        // return $data;

        if ($data['paymentIntent']['status'] === 'succeeded') {
            //continue to next
        } else {
            return response()->json(['errorMsg' => 'Payment Intent Not Succeeded']);
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

                'payment_intent_id' => $data['paymentIntent']['id'],
                'payment_intent_amount' => $data['paymentIntent']['amount'] / 100,
                'payment_created_at' => (new DateTime())
                    ->setTimestamp($data['paymentIntent']['created'])
                    ->format('Y-m-d H:i:s'),
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

            return response()->json([
                                        'errorMsg' => null,
                                        'successMsg' => 'Payment Intent Succeeded',
                                        'countCart' => 0,
                                        'orderId' => $order->id,
                                    ]);

            ////https://stackoverflow.com/questions/30019627/redirectroute-with-parameter-in-url-in-laravel-5
            ////return \Redirect::route('order.orderDetailsById', [$order->id]);
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
        $oldCart = Session::get('cart');

        $cart = new Cart($oldCart);

        $count = $cart->countOfItems;

        // return $cart->items;

        if ($count < 1){
            $errorMsg = "No items to check out.";
            return view('checkout.checkOut', compact('errorMsg'));
        }

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

    public function getPaymentIntent()
    {
        $oldCart = Session::get('cart');

        $cart = new Cart($oldCart);

        $count = $cart->countOfItems;

        // return $cart->items;

        if ($count < 1){
            $errorMsg = "No items to check out.";
            return response()->json([
                'errorMsg' => $errorMsg,
            ]);
        }

        $totalPrice = 0;
        foreach($cart->items as $item){
            $totalPrice += $item['qty'] * $item['price'];
        }

        $totalSalePrice = 0;
        foreach($cart->items as $item){
            $totalSalePrice += $item['qty'] * $item['salePrice'];
        }

        ////$grandAmount = $totalSalePrice + shippingCost

        $shippingCost = 10; ////추후에 결정 할것...
        $grandAmount = $totalSalePrice + $shippingCost;

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $intent = PaymentIntent::create([
            'amount' => $grandAmount * 100, //소수점 문제로...
            'currency' => 'nzd',
            'payment_method_types' => ['card'],
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],////???
        ]);

        // return $intent;

        $clientSecret = Arr::get($intent,'client_secret');


        return response()->json([
            'clientSecret' => $clientSecret,
            'errorMsg' => null,
            'userName' => auth()->user()->name,
        ]);
    }

    public function showPayNow()
    {
        return view('checkout.showPayNow');
    }

    public function payNow()
    {
        $oldCart = Session::get('cart');

        $cart = new Cart($oldCart);

        $count = $cart->countOfItems;

        // return $cart->items;

        if ($count < 1){
            $errorMsg = "No items to check out.";
            return view('checkout.payNow', ['clientSecret' => null,
                                            'errorMsg' => $errorMsg,
                                            'userName' => auth()->user()->name,
                                            ]);
        }

        $totalPrice = 0;
        foreach($cart->items as $item){
            $totalPrice += $item['qty'] * $item['price'];
        }

        $totalSalePrice = 0;
        foreach($cart->items as $item){
            $totalSalePrice += $item['qty'] * $item['salePrice'];
        }

        ////$grandAmount = $totalSalePrice + shippingCost

        $shippingCost = 10; ////추후에 결정 할것...
        $grandAmount = $totalSalePrice + $shippingCost;

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $intent = PaymentIntent::create([
            'amount' => $grandAmount * 100, //소수점 문제로...
            'currency' => 'nzd',
            'payment_method_types' => ['card'],
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment',
                           'customer_email' => auth()->user()->email,
                           'customer_name' => auth()->user()->name,
                          ],
        ]);

        // return $intent;

        $clientSecret = Arr::get($intent,'client_secret');

        return view('checkout.payNow',['clientSecret' => $clientSecret,
                                        'errorMsg' => null,
                                        'userName' => auth()->user()->name,
                                        'grandAmount' => $grandAmount,
                                      ]);
    }
}
