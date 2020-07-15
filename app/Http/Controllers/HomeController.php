<?php

// https://www.youtube.com/watch?v=4J939dDUH4M&list=PL55RiY5tL51qUXDyBqx0mKVOhLNFwwxvH&index=9
// https://www.youtube.com/watch?v=TCFyCZNnj_w

namespace App\Http\Controllers;

use App\Product;
use App\Categorya;
use App\Categoryb;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    public function showVerificationMsg()
    {
        return view('home.showVerificationMsg');
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
    public function index() //do not delete for test
    {
        // $products = Product::take(20)->get();

        // $products = Product::inRandomOrder()->take(20)->get();

        $products = Product::take(20)->get();

        return view('home.index',['allProducts' => $products]);
    }

    public function home()
    {
        //redis에 cache key 'categoryas'가 존재하면 cache에서 data를 읽어 오고
        //그렇지 않으면 db에서 읽어온 data를 cache에 저장 한다.
        $categoryas = Cache::store('redis')->remember('home.categoryas', now()->addHours(24), function() {
            return (Categorya::with('categorybs')->get());
        });

        // $categoryas = Categorya::with('categorybs')
        //                 ->get();

        $bestProducts = Product::inRandomOrder()->take(12)->get();

        $newArrivalProducts = Product::inRandomOrder()->take(12)->get();

        // return $categoryas;
        return view('home.home', compact('categoryas','bestProducts','newArrivalProducts'));
    }

    public function allCategory()
    {
        //redis에 cache key 'categorybs'가 존재하면 cache에서 data를 읽어 오고
        //그렇지 않으면 db에서 읽어온 data를 cache에 저장 한다.
        $categorybs = Cache::store('redis')->remember('home.categorybs', now()->addHours(24), function() {
            return (Categoryb::with('categorycs')->get());
        });

        // $categorybs = Categoryb::with('categorycs')
        //                 ->get();

        // return $allCategory;
        return (string) view('home.allCategory', compact('categorybs'));
    }
}
