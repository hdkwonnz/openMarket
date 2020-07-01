<?php

// https://www.youtube.com/watch?v=4J939dDUH4M&list=PL55RiY5tL51qUXDyBqx0mKVOhLNFwwxvH&index=9
// https://www.youtube.com/watch?v=TCFyCZNnj_w

namespace App\Http\Controllers;

use App\Product;
use App\Categorya;
use App\Categoryb;
use App\Categoryc;
use Illuminate\Http\Request;

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
        $productsCategoryAs = Product::with('categorya','categoryb','categoryc')
                        ->where('categorya_id', '=', $aId)
                        ->get();

        $categoryABs = Categorya::with('categorybs')
                        ->where('id', '=', $aId)
                        ->first();
        return view('product.showProductsCategoryAB', compact('productsCategoryAs','categoryABs'));
    }

    public function showProductsCategoryBC($bId)
    {
        $productsCategoryBCs = Product::with('categorya','categoryb','categoryc')
                        ->where('categoryb_id', '=', $bId)
                        ->get();

        $categoryBCs = Categoryb::with('categorycs', 'categorya')
                        ->where('id', '=', $bId)
                        ->first();
        //return $categoryBCs;
        return view('product.showProductsCategoryBC', compact('productsCategoryBCs','categoryBCs'));
    }

    public function showProductsCategoryC($cId)
    {
        $productsCategoryCs = Product::with('categorya','categoryb','categoryc')
                        ->where('categoryc_id', '=', $cId)
                        ->get();

        $categoryCs = Categoryc::with('categoryb', 'categorya')
                        ->where('id', '=', $cId)
                        ->first();
        //return $categoryCs;
        return view('product.showProductsCategoryC', compact('productsCategoryCs','categoryCs'));
    }

}
