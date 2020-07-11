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

    // public function deleteAllInCart()
    // {
    //     if (!Session::has('cart')){
    //         return back()->with('message', 'No Session Exists...');
    //     }

    //     session()->forget('cart');

    //     return back();
    // }

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

    ////for blade.php below
    // public function changeInCart(Request $request, $id)
    // {
    //     $product = Product::find($id);

    //     // $item = ['qty' => request('qty'), 'price' => $product->price, 'name' => $product->name, 'productId' => $product->id];
    //     $item = [
    //                 'qty' => request('qty'),
    //                 'price' => $product->price,
    //                 'salePrice' => $product->sale_price,
    //                 'saleRate' => $product->sale_rate,
    //                 'name' => $product->name,
    //                 'productId' => $product->id,
    //                 'imagePath' => $product->image_path
    //             ];

    //     $oldCart = Session::has('cart')? Session::get('cart') : null;

    //     $cart = new Cart($oldCart);

    //     $cart->change($item, $id);

    //     $request->session()->put('cart', $cart);

    //     //dd($request->session()->get('cart'));

    //     return back();

    // }

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


    // public function deleteInCart(Request $request, $id)
    // {
    //     // return ("id =   " . $id);

    //     // $product = Product::findOrFail($id);

    //     $oldCart = Session::has('cart')? Session::get('cart') : null;

    //     $cart = new Cart($oldCart);

    //     // $cart->delete($product->id);
    //     $cart->delete($id);
    //     $request->session()->put('cart', $cart);

    //     // dd($request->session()->get('cart'));

    //     return back();

    // }

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

    // public function addToCart(Request $request)
    // {
    //     //return ('qty = ' . request('qty'));
    //     // return ('id = ' . request('id'));

    //     $product = Product::findOrFail(request('id'));

    //     // $item = ['qty' => 1, 'price' => $product->price, 'name' => $product->name, 'productId' => $product->id];
    //     $item =
    //             [
    //                 'qty' => request('qty'),
    //                 'price' => $product->price,
    //                 'salePrice' => $product->sale_price,
    //                 'saleRate' => $product->sale_rate,
    //                 'name' => $product->name,
    //                 'productId' => $product->id,
    //                 'imagePath' => $product->image_path
    //             ];

    //     $oldCart = Session::has('cart')? Session::get('cart') : null;

    //     $cart = new Cart($oldCart);

    //     $cart->add($item,$product->id);
    //     $request->session()->put('cart', $cart);

    //     // dd($request->session()->get('cart'));

    //     return back();

    //     //////////DO NOT DELETE BELOW => ORIGINAL CODE FROM YOUTUBE///////////////////////////

    //     // $product = Product::find($id);

    //     // $oldCart = Session::has('cart')? Session::get('cart') : null;

    //     // $cart = new Cart($oldCart);
    //     // $cart->add($product,$product->id);
    //     // $request->session()->put('cart', $cart);

    //     // // dd($request->session()->get('cart'));

    //     // return back();
    // }

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
        // $totalPrice = number_format($totalPrice, 2);

        $totalSalePrice = 0;
        foreach($cart->items as $item){
            $totalSalePrice += $item['qty'] * $item['salePrice'];
        }
        // $totalSalePrice = number_format($totalSalePrice, 2);

        return response()->json([
            'products' => $cart->items,
            'totalPrice' => $totalPrice,
            'totalSalePrice' => $totalSalePrice,
            'countOfItems' => $cart->countOfItems
        ]);

    }

    ////for blade.php below
    // public function getCart()
    // {
    //     if (!Session::has('cart')){
    //         return view('cart.getCart');
    //     }

    //     $oldCart = Session::get('cart');

    //     $cart = new Cart($oldCart);

    //     // return $cart->items;

    //     $totalPrice = 0;
    //     foreach($cart->items as $item){
    //         $totalPrice += $item['qty'] * $item['price'];
    //     }

    //     $totalSalePrice = 0;
    //     foreach($cart->items as $item){
    //         $totalSalePrice += $item['qty'] * $item['salePrice'];
    //     }

    //     return view('cart.getCart',['products' => $cart->items,'totalPrice' => $totalPrice, 'totalSalePrice' => $totalSalePrice]);

    //     //////////DO NOT DELETE BELOW => ORIGINAL CODE FROM YOUTUBE///////////////////////////

    //     // if (!Session::has('cart')){
    //     //     return view('cart.getCart');
    //     // }

    //     // $oldCart = Session::get('cart');

    //     // $cart = new Cart($oldCart);

    //     // return view('cart.getCart',['products' => $cart->items, 'totalPrice'=> $cart->totalPrice]);
    // }
}
