<?php

namespace App\Http\Controllers\Seller;

use App\Categorya;
use App\Categoryb;
use App\Categoryc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    public function test($id)
    {
        $product = Product::findOrFail($id);

        $photos = unserialize($product->photo_paths);

        foreach ($photos as $photo){
            //return $photo;
        }

        return unserialize($product->photo_paths);
    }

    public function showEditProduct($productId)
    {

        return view('seller/product/showEditProduct',compact('productId'));

    }

    public function showMyProducts()

    {
        return view('seller.product.showMyProducts');

    }

    public function getMyProductById()
    {
        $product = Product::with('categorya','categoryb','categoryc')
                                ->where('user_id','=',auth()->user()->id)
                                ->where('id','=',request('productId'))
                                ->first();

        if (!$product){
            return response()->json([
                'errorMsg' => "Not found product Id."
            ]);
        }

        $photos = unserialize($product->photo_paths);
        return response()->json([
            'product' => $product,
            'photos' => $photos,
            'errorMsg' => null,
        ]);
    }

    public function getMyProducts()
    {
        $products = Product::where('user_id','=',auth()->user()->id)
                                ->orderBy('created_at','desc')
                                ->get();

        return response()->json([
            'products' => $products,
        ]);
    }

    public function showProductInputForm()
    {
        return view('seller.product.productInput');
    }

    public function addProduct(Request $request)
    {
        //return $request->all();

        ////https://stackoverflow.com/questions/42342411/laravel-validation-check-array-size-min-and-max
        $request->validate([
            'categoryAid' => 'required|numeric',
            'categoryBid' => 'required|numeric',
            'categoryCid' => 'required|numeric',
            'productName' => ["required","min:2","max:200"],
            'normalPrice' => ["required","numeric"],
            'salePrice' => ["nullable","numeric"],
            'stockQty' => ["nullable","numeric"],
            'imagePath' => ["required","min:2","max:255"],
            'photoPaths' => ["nullable","max:255"],
            'detailsPath' => ["nullable","max:255"],
            'countryOfOrigin' => ["required", "max:15"],
            'manufacturer' => ["nullable","max:255"],
            'option' => ["nullable","numeric"],
        ]);

        $photos = [];
        $i = 0;
        foreach ($request->photoPaths as $photo) {
            $photos[$i][] = $photo;
            $i++;
        }
        $serializedPhotos = serialize($photos);

        if (!($request->salePrice)){
            $request->salePrice = $request->normalPrice;
        }

        $product = Product::create([
            'status' => 'pending',
            'categorya_id' => $request->categoryAid,
            'categoryb_id' => $request->categoryBid,
            'categoryc_id' => $request->categoryCid,
            'user_id' => auth()->user()->id,
            'name' => $request->productName,
            'price' => $request->normalPrice,
            'sale_price' => $request->salePrice,
            'stock' => $request->stockQty,
            'country_origin' => $request->countryOfOrigin,
            'image_path' => $request->imagePath,
            'photo_paths' => $serializedPhotos,
            'details_path' => $request->detailsPath,
            'ingredients' => $request->ingredients,
            //'number_option' => 0,///////////
            'sku' => $request->skuNumber,
            'brand' => $request->manufacturer,
            'number_option' => $request->option,
        ]);

        return response()->json([
            'productId' => $product->id,
        ]);
    }

    public function getCategoryAs()
    {
        $categoryAs = Categorya::all();

        return response()->json([
            'categoryAs' => $categoryAs,
        ]);
    }

    public function getCategoryBbyId()
    {
        $categoryBs = Categoryb::where('categorya_id','=',request(('id')))
                                ->get();

        return response()->json([
            'categoryBs' => $categoryBs,
        ]);
    }
    public function getCategoryCbyId()
    {
        $categoryCs = Categoryc::where('categorya_id','=',request(('aId')))
                                ->where('categoryb_id','=',request(('bId')))
                                ->get();

        return response()->json([
            'categoryCs' => $categoryCs,
        ]);
    }
}
