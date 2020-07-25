<?php

namespace App\Http\Controllers\Admin;

use App\Carouselone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showCarouselOne()
    {
        return view('admin.product.showCarouselOne');
    }

    public function getCarouselOne()
    {
        $carouselOnes = Carouselone::all();

        return response()->json([
            'carouselOnes' => $carouselOnes,
        ]);
    }

    public function editCarouselOne(Request $request)
    {
        //return $request->all();

        for ($i = 0; $i < 3; $i++){
            $carouselOne = Carouselone::findOrFail($request->carouselOneId[$i]);
            $carouselOne->product_id = $request->productId[$i];
            $carouselOne->image_path = $request->imagePath[$i];
            $carouselOne->update();
        }

        return response()->json([
            'successMsg' => 'Completed to update.',
        ]);
    }

}
