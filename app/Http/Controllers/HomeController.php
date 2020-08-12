<?php

// https://www.youtube.com/watch?v=4J939dDUH4M&list=PL55RiY5tL51qUXDyBqx0mKVOhLNFwwxvH&index=9
// https://www.youtube.com/watch?v=TCFyCZNnj_w

namespace App\Http\Controllers;

use App\Carouselone;
use App\Product;
use App\Categorya;
use App\Categoryb;
use Cookie;

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

    //myJs/layout/reCall.js 에서 콜한다.
    public function deletCookieProduct(Request $request)
    {
        // return $request->id;
        $id = $request->id;

        $minutes_to_store = 1440; // These cookies will automatically be forgotten after this number of minutes. 1440 is 24 hours.
        if (Cookie::get('recently_viewed_content')){//if Cookie 'recently_viewed_content' exists
            $recent = Cookie::get('recently_viewed_content');
            // Since cookies must be strings, the data is stored as JSON.
            // Decode the data.
            // The second parameter, "[w]hen TRUE, returned objects will be
            // converted into associative arrays."
            $recent = json_decode($recent, TRUE);
            // If the 'id' exists in the user's history, delete it.
            if ( $recent ) {
                foreach ( $recent as $key=>$val ) {
                        if ( $val["id"] == $id)
                            unset( $recent[$key] );
                }
                // Queue the updated "recently viewed" list to update on the user's next page load
                // I.e., don't show the current page as "recently viewed" until
                // they navigate away from it (or otherwise refresh the page)
                Cookie::queue('recently_viewed_content', json_encode($recent), $minutes_to_store);
            }
        }
        return 1;////

        ////below old code ==> do not delete
        // if (Cookie::get('myProducts'))   //myProducts라는 쿠키가 존재하면...
        // {
        //     foreach (Cookie::get('myProducts') as $name => $value)   //쿠키를 순서대로 읽어서
        //     {
        //         $name = htmlspecialchars($name);
        //         $value = htmlspecialchars($value);
        //         if ($name == $id) //삭제를 원하는 상품이 있으면 삭제한다.
        //         {
        //             $myCookie = 'myProducts' . '[' . $id . ']';
        //             Cookie::queue($myCookie, $value,  -1, '/'); //-1은 분을 의미(1시간 = 60초 * 60초)
        //         }                                               //일분 전에 쿠키가 지워졌다는 의미...
        //     }
        // }
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

        $carouselones = Cache::store('redis')->remember('home.carouselones', now()->addHours(24), function() {
            return (Carouselone::all());
        });

        $bestProducts = Product::inRandomOrder()->take(12)->get();

        $newArrivalProducts = Product::inRandomOrder()->take(12)->get();

        // return $categoryas;
        return view('home.home', compact('categoryas','bestProducts','newArrivalProducts','carouselones'));
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
