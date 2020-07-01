<?php

// https://www.youtube.com/watch?v=4J939dDUH4M&list=PL55RiY5tL51qUXDyBqx0mKVOhLNFwwxvH&index=9
// https://www.youtube.com/watch?v=TCFyCZNnj_w

namespace App\Http\Controllers;

use App\Product;
use App\Categorya;
use App\Categoryb;
// use App\Categoryc;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function search()
    {
        $searchTerm = request('searchTerm');
        $errorMessage = "";

        if (!$searchTerm ) {
            $errorMessage = "Please, enter search term.";
            return view('home.search',compact('errorMessage'));
        }

        $products = Product::
                select('*')
                ->where(function($q) use($searchTerm)
                {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('country_origin', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('ingredients', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('nutrition_facts', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('info', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('sku', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('products.id', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhereHas('categorya', function($qq) use($searchTerm){
                            $qq->where('name', 'LIKE', '%' . $searchTerm . '%');
                        })
                        ->orWhereHas('categoryb', function($qq) use($searchTerm){
                            $qq->where('name', 'LIKE', '%' . $searchTerm . '%');
                        })
                        ->orWhereHas('categoryc', function($qq) use($searchTerm){
                            $qq->where('name', 'LIKE', '%' . $searchTerm . '%');
                        });
                })
                ->get();

        return view('home.search',compact('products','errorMessage'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $products = Product::take(20)->get();

        // $products = Product::inRandomOrder()->take(20)->get();

        $products = Product::take(20)->get();

        return view('home.index',['allProducts' => $products]);
    }

    public function home()
    {
        $categoryas = Categorya::with('categorybs')
                        ->get();

        $bestProducts = Product::inRandomOrder()->take(12)->get();

        $newArrivalProducts = Product::inRandomOrder()->take(12)->get();

        // return $categoryas;
        return view('home.home', compact('categoryas','bestProducts','newArrivalProducts'));
    }

    public function allCategory()
    {
        $categorybs = Categoryb::with('categorycs')
                        ->get();

        // return $allCategory;
        return (string) view('home.allCategory', compact('categorybs'));
    }
}
