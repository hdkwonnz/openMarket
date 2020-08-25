<?php

namespace App\Http\Controllers;

use Session;
use App\Cart;
use DateTime;
use App\Order;
use App\Address;
use App\Errorlog;
use App\Events\NoticeToSellerEvent;
use Stripe\Stripe;
use App\Orderdetail;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Jobs\OrderdetailsEmailJob;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        return view('checkout.showCheckout');
    }

    public function getAddresses()
    {
        $addresses = Address::where('user_id','=',auth()->user()->id)
                            ->get();

        return response()->json([
            'addresses' => $addresses,
        ]);
    }

    public function deleteAddress(Request $request)
    {
        $address = Address::findOrFail($request->id);

        if ($address){
            $address->delete();
        }

        return response()->json([
            'successMsg' => 'good',////
        ]);
    }

    public function payment(Request $request)
    {
        if (!Session::has('cart')){
            Errorlog::create([
                            'user_name' => auth()->user()->name,
                            'user_email' => auth()->user()->email,
                            'error_message' => "Unable to checkout due to cart session already deleted. => Checkout@payment",
                      ]);
            return response()->json([
                                        'errorMsg' => "Unable to checkout due to cart session already deleted. => Checkout@payment",
                                    ]);
        }

        ////payNow.blade.php => body: JSON.stringify({paymentIntent: paymentIntent})로 넘어 왔기 때문에...
        $data = $request->json()->all();

        // return $data;

        ////payNow.blade.php에서 아래 data 를 보낼 경우 이곳에서 받는 방법.
        // $address = $data['address'];
        $addressee = $data['addressee'];
        $addressId = $data['addressId'];
        $shippingCost = $data['shippingCost'];

        // return ("Addressee=" . $addressee . " address=" . $address . " addressId=" . $addressId);

        if ($data['paymentIntent']['status'] === 'succeeded') {
            //continue to next
        } else {
            Errorlog::create([
                'user_name' => auth()->user()->name,
                'user_email' => auth()->user()->email,
                'error_message' => "Payment Intent Not Succeeded. => Checkout@payment",
          ]);
            return response()->json(['errorMsg' => 'Payment Intent Not Succeeded. => Checkout@payment']);
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

        if ($totalSalePrice < 0.1){
            Errorlog::create([
                'user_name' => auth()->user()->name,
                'user_email' => auth()->user()->email,
                'error_message' => "Too low price to check out => Checkout@payment",
          ]);
            return response()->json(['errorMsg' => 'Too low price to check out => Checkout@payment.']);
        }

        $products = $cart->items;

        DB::beginTransaction();

        try{
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'total_amount' => $totalSalePrice,
                'shipping_cost' => $shippingCost,
                'address_id' => $addressId,
                'addressee' => $addressee,
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

            $orderDetails = Order::with('user','address','orderdetails')
                        ->where('id','=',$order->id)
                        ->first();

            ////email to customer
            ////보낼 메일을 jobs table로 passing 한다.
            ////반드시 php artisan queue:work --tries=2 --sleep=10 type 할 것.
            $job = (new OrderdetailsEmailJob($orderDetails))
                    ->delay(now()->addSeconds(10));
            $this->dispatch($job);

            ////이곳에서 각 product owner에게 order 된 내용을 email로 발송해야 된다.
            //
            //
            //

            ////seller에게 solid message를 보낸다.
            ////현재는 test 중이라 buyer에게 보낸다.
            //event(new NoticeToSellerEvent($order));


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

            Errorlog::create([
                'user_name' => auth()->user()->name,
                'user_email' => auth()->user()->email,
                'error_message' => "woops! data base errors on Checkout@payment. => Checkout@payment",
            ]);

            return response()->json([
                'errorMsg' => 'woops! data base errors on Checkout@payment.',
            ]);
        }
    }

    public function getCheckout()
    {
        $oldCart = Session::get('cart');

        $cart = new Cart($oldCart);

        $count = $cart->countOfItems;

        // return $cart->items;

        $errorMsg = "No items to check out.";

        if ($count < 1){
            return response()->json([
                'errorMsg' =>  $errorMsg,
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

        if ($totalSalePrice < 0.1){
            return response()->json([
                'errorMsg' =>  $errorMsg,
            ]);
        }

        //////////////////////////////////////////////////////////////////////////////////////////////
        ////shipping cost => CartController@getCart 애서 이미 정했지만 다시 보여 준다./////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        if ($totalSalePrice > 299.99){
            $shippingCost = 0;
        }else{
            $shippingCost = 20.00;
        }
        //////////////////////////////////////////////////////////////////////////////////////////////

        $addresses = Address::where('user_id','=',auth()->user()->id)
                            ->get();

        return response()->json(['products' => $cart->items, 'totalPrice' => $totalPrice,
                                 'totalSalePrice' => $totalSalePrice, 'count' => $count,
                                 'errorMsg' => null, 'addresses' => $addresses,
                                 'shippingCost' => $shippingCost,]);

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
        return json_encode(array('clientSecret' => $intent->client_secret));

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

    // public function payNow($address)
    public function payNow($address, $addressee, $addressId)
    {
        // return ($address . '###' . $addressee . '###' . $addressId);

        if (($address == "") || ($addressee == "")){
            $errorMsg = "Please select address and addressee.";
            return view('checkout.payNow', ['clientSecret' => null,
                                            'errorMsg' => $errorMsg,
                                            'userName' => auth()->user()->name,
                                            ]);
        }

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

        if ($totalSalePrice < 0.1){
            $errorMsg = "Too low price to check out.";
            return view('checkout.payNow', ['clientSecret' => null,
                                            'errorMsg' => $errorMsg,
                                            'userName' => auth()->user()->name,
                                            ]);
        }

        ////add address data to Address tabel.
        if ($addressId > 0 ){
            $existingAddress = Address::where('id','=',$addressId)
                                ->where('user_id','=',auth()->user()->id)
                                ->first();
            if ($existingAddress->address != $address){
                $newAddress = Address::create([
                                'user_id' => auth()->user()->id,
                                'address' => $address,
                                'addressee' => $addressee,
                ]);

                $addressId = $newAddress->id;
            }
        }else{
            $newAddress = Address::create([
                'user_id' => auth()->user()->id,
                'address' => $address,
                'addressee' => $addressee,
            ]);

            $addressId = $newAddress->id;
        }

        /////////////////////////////////////////////////////////////////
        ////이곳에서 최후로 shipping cost를 결정 한다. ///////////////////
        /////////////////////////////////////////////////////////////////
        if ($totalSalePrice > 299.99){
            $shippingCost = 0;
        }else{
            $shippingCost = 20.00;
        }
        //////////////////////////////////////////////////////////////////

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
                                        'shippingCost' => $shippingCost,
                                        'address' => $address,
                                        'addressee' => $addressee,
                                        'addressId' => $addressId
                                      ]);
    }
}
