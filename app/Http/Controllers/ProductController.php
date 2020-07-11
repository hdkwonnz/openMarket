<?php

// https://www.youtube.com/watch?v=4J939dDUH4M&list=PL55RiY5tL51qUXDyBqx0mKVOhLNFwwxvH&index=9
// https://www.youtube.com/watch?v=TCFyCZNnj_w

namespace App\Http\Controllers;

use App\Product;
use App\Categorya;
use App\Categoryb;
use App\Categoryc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        $product = Product::with('categorya','categoryb','categoryc')
                                ->findOrFail($id);

        // if (!$product){
        //     return back()->with('message', 'Product Id does not exist.');
        // }

        return view('product.details', compact('product'));
    }

    public function showProductsCategoryAB($aId)
    {
        //redis에 cache key 'categorybs'가 존재하면 cache에서 data를 읽어 오고
        //그렇지 않으면 db에서 읽어온 data를 cache에 저장 한다.
        $productsCategoryAs = Cache::store('redis')->remember('productsCategoryAs'.$aId, now()->addHours(24), function() use($aId) {
            return (Product::with('categorya','categoryb','categoryc')
                            ->where('categorya_id', '=', $aId)
                            ->get());
        });

        // return $productsCategoryAs;

        // $productsCategoryAs = Product::with('categorya','categoryb','categoryc')
        //                 ->where('categorya_id', '=', $aId)
        //                 ->get();

        $categoryABs = Cache::store('redis')->remember('product.categoryABs'.$aId, now()->addHours(24), function() use($aId) {
            return (Categorya::with('categorybs')
                            ->where('id', '=', $aId)
                            ->first());
        });

        // return $categoryABs;

        // $categoryABs = Categorya::with('categorybs')
        //                 ->where('id', '=', $aId)
        //                 ->first();

        return view('product.showProductsCategoryAB', compact('productsCategoryAs','categoryABs'));
    }

    public function showProductsCategoryBC($bId)
    {
        $productsCategoryBCs = Cache::store('redis')->remember('productsCategoryBCs'.$bId, now()->addHours(24), function() use($bId) {
            return (Product::with('categorya','categoryb','categoryc')
                            ->where('categoryb_id', '=', $bId)
                            ->get());
        });

        // $productsCategoryBCs = Product::with('categorya','categoryb','categoryc')
        //                 ->where('categoryb_id', '=', $bId)
        //                 ->get();

        $categoryBCs = Cache::store('redis')->remember('product.categoryBCs'.$bId, now()->addHours(24), function() use($bId) {
            return (Categoryb::with('categorycs', 'categorya')
                            ->where('id', '=', $bId)
                            ->first());
        });

        // $categoryBCs = Categoryb::with('categorycs', 'categorya')
        //                 ->where('id', '=', $bId)
        //                 ->first();

        //return $categoryBCs;

        return view('product.showProductsCategoryBC', compact('productsCategoryBCs','categoryBCs'));
    }

    public function showProductsCategoryC($cId)
    {
        $productsCategoryCs = Cache::store('redis')->remember('productsCategoryCs'.$cId, now()->addHours(24), function() use($cId) {
            return (Product::with('categorya','categoryb','categoryc')
                            ->where('categoryc_id', '=', $cId)
                            ->get());
        });

        // $productsCategoryCs = Product::with('categorya','categoryb','categoryc')
        //                 ->where('categoryc_id', '=', $cId)
        //                 ->get();

        $categoryCs = Cache::store('redis')->remember('product.categoryCs'.$cId, now()->addHours(24), function() use($cId) {
            return (Categoryc::with('categoryb', 'categorya')
                            ->where('id', '=', $cId)
                            ->first());
        });

        // $categoryCs = Categoryc::with('categoryb', 'categorya')
        //                 ->where('id', '=', $cId)
        //                 ->first();

        //return $categoryCs;

        return view('product.showProductsCategoryC', compact('productsCategoryCs','categoryCs'));
    }

}
