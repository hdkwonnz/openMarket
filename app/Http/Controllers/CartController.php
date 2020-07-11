<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
    public function countCart()
    {
        $oldCart = Session::has('cart')? Session::get('cart') : null;

        $cart = new Cart($oldCart);

        return response()->json([
            'countOfItems' => $cart->countOfItems
        ]);
    }

    public function deleteAllInCart()
    {
        if (!Session::has('cart')){
            return back()->with('message', 'No Session Exists...');
        }

        session()->forget('cart');

        return response()->json([
            'errorMsg' => 'No Items in Cart.',
            'countOfItems' => 0,
        ]);
    }

    public function changeInCart(Request $request)
    {
        if (request('qty') > 99){
            return response()->json([
                'errorMsg' => 'Qty should be less than 100 each.',
            ]);
        }

        if (request('qty') < 1){
            return response()->json([
                'errorMsg' => "Please enter qty to add to cart.",
            ]);
        }

        $product = Product::find(request('id'));

        // $item = ['qty' => request('qty'), 'price' => $product->price, 'name' => $product->name, 'productId' => $product->id];
        $item = [
                    'qty' => request('qty'),
                    'price' => $product->price,
                    'salePrice' => $product->sale_price,
                    'saleRate' => $product->sale_rate,
                    'name' => $product->name,
                    'productId' => $product->id,
                    'imagePath' => $product->image_path
                ];

        $oldCart = Session::has('cart')? Session::get('cart') : null;

        $cart = new Cart($oldCart);

        $cart->change($item, request('id'));

        $request->session()->put('cart', $cart);

        //dd($request->session()->get('cart'));

        return response()->json([
            'successMsg' => 'Completed to edit.',
        ]);

    }

    public function deleteInCart(Request $request)
    {
        // return ("id =   " . $id);

        // $product = Product::findOrFail($id);

        $oldCart = Session::has('cart')? Session::get('cart') : null;

        $cart = new Cart($oldCart);

        // $cart->delete($product->id);
        $cart->delete(request('id'));
        $request->session()->put('cart', $cart);

        // dd($request->session()->get('cart'));

        if ($cart->countOfItems == 0){
            $errorMsg = "No Items in Cart.";
        }else{
            $errorMsg = null;
        }


        return response()->json([
            'errorMsg' => $errorMsg,
            'countOfItems' => $cart->countOfItems,
        ]);

    }

    public function addToCart(Request $request)
    {
        // return ('qty = ' . request('qty') . 'id = '. request('id'));
        // return ('id = ' . request('id'));

        if (!request('id')){
            return response()->json([
                'errorMsg' => "Please select product to add to cart.",
            ]);
        }

        if (request('qty') < 1){
            return response()->json([
                'errorMsg' => "Please enter qty to add to cart.",
            ]);
        }

        $product = Product::findOrFail(request('id'));

        if (!$product){
            return response()->json([
                'errorMsg' => "Product Id dose not exist.",
            ]);
        }

        // $item = ['qty' => 1, 'price' => $product->price, 'name' => $product->name, 'productId' => $product->id];
        $item =
                [
                    'qty' => request('qty'),
                    'price' => $product->price,
                    'salePrice' => $product->sale_price,
                    'saleRate' => $product->sale_rate,
                    'name' => $product->name,
                    'productId' => $product->id,
                    'imagePath' => $product->image_path
                ];

        $oldCart = Session::has('cart')? Session::get('cart') : null;

        $cart = new Cart($oldCart);

        $cart->add($item,$product->id);
        $request->session()->put('cart', $cart);

        // dd($request->session()->get('cart'));

        return response()->json([
            'successMsg' => "Completed to add to cart.",
            'countOfItems' => $cart->countOfItems,
        ]);

        //////////DO NOT DELETE BELOW => ORIGINAL CODE FROM YOUTUBE///////////////////////////

        // $product = Product::find($id);

        // $oldCart = Session::has('cart')? Session::get('cart') : null;

        // $cart = new Cart($oldCart);
        // $cart->add($product,$product->id);
        // $request->session()->put('cart', $cart);

        // // dd($request->session()->get('cart'));

        // return back();
    }

    public function showCart()
    {
        return view('cart.showCart');
    }

    public function getCart()
    {
        if (!Session::has('cart')){
            return response()->json([
                'errorMsg' => 'No Items in Cart.',
            ]);
        }

        $oldCart = Session::get('cart');

        $cart = new Cart($oldCart);

        // return $cart->items;

        if ($cart->countOfItems < 1){
            return response()->json([
                'errorMsg' => 'No Items in Cart.',
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

        //////////////////////////////////////////////////////////
        ////이곳에서 shipping cost를 정해야 한다./////////////////
        /////////////////////////////////////////////////////////
        if ($totalSalePrice > 299.99){
            $shippingCost = 0;
        }else{
            $shippingCost = 20.00;
        }
        /////////////////////////////////////////////////////////

        return response()->json([
            'products' => $cart->items,
            'totalPrice' => $totalPrice,
            'totalSalePrice' => $totalSalePrice,
            'countOfItems' => $cart->countOfItems,
            'shippingCost' => $shippingCost,
        ]);

    }
}
