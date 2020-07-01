<?php

namespace App\Http\Controllers;

use App\Firstoption;
use App\Product;
use App\Secondoption;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function showOptionConnections()
    {
        $firstOptionId = $_GET['firstOptionId'];

        if (!$firstOptionId){
            return "No first option to show...";
        }

        $firstToSecondOption = Firstoption::with('secondoptions')
                                    ->where('id','=',$firstOptionId)
                                    ->orderBy('description', 'asc')
                                    ->first(); ////not use get()!!!!

        // return $firstToSecondOptions;
        return (string) view('seller.firstToSecondOptionsResult', compact('firstToSecondOption'));
    }

    public function showFirstOptions()
    {
        $product = Product::first();

        $firstOptions = Firstoption::where('product_id','=',$product->id)
                            ->orderBy('description','asc')
                            ->get();

        return view('seller.showFirstOptions', compact('product','firstOptions'));
    }

    public function showProductOptions()
    {
        $product = Product::first();

        $firstOptions = Firstoption::where('product_id','=',$product->id)
                            ->orderBy('description','asc')
                            ->get();

        $secondOptions = Secondoption::where('product_id','=',$product->id)
                            ->orderBy('description','asc')
                            ->get();

        return view('seller.showProductOptions', compact('product','firstOptions','secondOptions'));
    }

    public function connectProductOptions(Request $request)
    {
        // return $request->all();

        if (!$request->firstOptionId){
            return "No first option to save...";
        }

        $secondOptionIds = $request->secondOptionIds;

        if (count($secondOptionIds) < 1){
            return "No second options to save...";
        }

        $firstOption = Firstoption::find($request->firstOptionId);

        // $secondOptions = Secondoption::where('product_id','=',$request->productId)
        //                     ->get();

        // $firstOption->secondOptions()->attach($secondOptions);

        // $firstOption->secondOptions()->syncWithoutDetaching($secondOptionIds);

        $firstOption->secondOptions()->sync($secondOptionIds);

        // return "Completed to connect selected options.";

        $firstToSecondOption = Firstoption::with('secondoptions')
                                    ->where('id','=',$request->firstOptionId)
                                    ->orderBy('description', 'asc')
                                    ->first(); ////not use get()!!!!

        // return $firstToSecondOptions;
        return (string) view('seller.firstToSecondOptionsResult', compact('firstToSecondOption'));

        // for ($i = 0; $i < count($secondOptionIds); $i++){
        //     $id = $secondOptionIds[$i];
        //     //Shoppingcart::destroy($id);
        // }
    }

    public function disConnectProductOptions(Request $request)
    {
        // return $request->all();

        if (!$request->firstOptionId){
            return "No first option to save...";
        }

        $secondOptionIds = $request->secondOptionIds;

        if (count($secondOptionIds) < 1){
            return "No second options to save...";
        }

        $firstOption = Firstoption::find($request->firstOptionId);

        // $secondOptions = Secondoption::where('product_id','=',$request->productId)
        //                     ->get();

        // $firstOption->secondOptions()->attach($secondOptions);

        // $firstOption->secondOptions()->syncWithoutDetaching($secondOptionIds);

        // $firstOption->secondOptions()->sync($secondOptionIds);

        $firstOption->secondOptions()->detach($secondOptionIds);


        // return "Completed to connect selected options.";

        $firstToSecondOption = Firstoption::with('secondoptions')
                                    ->where('id','=',$request->firstOptionId)
                                    ->orderBy('description', 'asc')
                                    ->first(); ////not use get()!!!!

        // return $firstToSecondOptions;
        return (string) view('seller.firstToSecondOptionsResult', compact('firstToSecondOption'));

        // for ($i = 0; $i < count($secondOptionIds); $i++){
        //     $id = $secondOptionIds[$i];
        //     //Shoppingcart::destroy($id);
        // }
    }
}
