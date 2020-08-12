<div class="container-fluid">
    <div class="row no-gutters">
        <div class="col-md-8 col-sm-8" style="position: fixed; left: 10px; bottom: 0px; z-index: 4; background-color: white;">

            <!-- below old code ==> do not delete -->
            {{-- @php
            $ix = 0;
            $count = 0;
            $products = [];  //어레이 선언
            if (Cookie::get('myProducts'))  //myProducts(ProductController@details/CartController@addToCart 에서 만든)라는쿠키가 있으면
            {
                $i = 0;
                foreach (Cookie::get('myProducts') as $name => $value)
                {
                    $name = htmlspecialchars($name);        //순서대로 읽어서 어레이에 저장한다.
                    $value = htmlspecialchars($value);
                    $products[$i]['pId'] = $name;
                    $products[$i]['fName'] = $value;
                    $i++;
                }
                $count = count($products);
                $ix = $count - 1;
            }
            @endphp --}}
            {{-- @if ($count > 0)
            <!-- 어레이에 저장된 내용을 역순으로 읽어 맨 끝 내용이 맨 앞으로 오게 한다. -->
            @for ($ii = $ix; $ii >= 0; $ii--)
            <div class="display_none show_watched" style="width: 100px; height: 100px; float: left;">
                <a class="show_image" href="{{ route('product.details', ['id' => $products[$ii]['pId']]) }}" target="_blank">
                    <img src={{ $products[$ii]['fName'] }} class="img-fluid img_thumb_nail" alt="">
                </a>
                <input type="hidden" class="product_id" value="{{ $products[$ii]['pId'] }}">
                <a href="javascript: void(0)" class="delete_watched">
                    <div style="border: 1px solid blue; width: 20px; height: 20px; top: -100px;
                    right: -80px; z-index: 3; position: relative; background: blue;
                    text-align: center;">
                        <span class="text-white">X</span>
                    </div>
                </a>
            </div>
            @endfor
            @endif --}}
            <!----------------------------------------------------------------------------------------------------->

            @php
            ////https://www.256kilobytes.com/content/show/3282/laravel-php-how-to-make-a-recently-viewed-posts-widget
            /*
            * This is a widget/whatever that shows a user links to their recently viewed posts.
            * Easily converted to plain PHP.
            */
            $recently_viewed_content = json_decode(\Cookie::get('recently_viewed_content'), TRUE);
            @endphp

            @if ( $recently_viewed_content )
            @php
            krsort( $recently_viewed_content );
            @endphp

            <div class="display_none show_watched" style="position: fixed; bottom: 80px; z-index: 4; border: 1px solid black; width: 40px; height: 40px; background-color: red;">
                <div class="watched_products text-center">
                    <i class="fas fa-times fa-3x"></i>
                </div>
            </div>
            @foreach ( $recently_viewed_content as $rvc)
            <div class="display_none show_watched" style="width: 100px; height: 100px; float: left;">
                <a class="show_image" href="{{ route('product.details', ['id' => $rvc['id']]) }}" target="_blank">
                    <img src={{ $rvc['url'] }} class="img-fluid img_thumb_nail" alt="">
                </a>
                <input type="hidden" class="product_id" value="{{ $rvc['id'] }}">
                <a href="javascript: void(0)" class="delete_watched">
                    <div style="border: 1px solid blue; width: 20px; height: 20px; top: -100px;
                    right: -80px; z-index: 3; position: relative; background: blue;
                    text-align: center;">
                        <span class="text-white">X</span>
                    </div>
                </a>
            </div>
            @endforeach
            @endif
        </div>
        {{-- <div class="col-md-1 col-sm-1">
            <div class="display_none show_watched" style="position: fixed; left: 1022px; bottom: 60px; z-index: 4; border: 1px solid black; width: 40px; height: 40px; background-color: red;">
                <div class="watched_products text-center">
                    <i class="fas fa-times fa-3x"></i>
                </div>
            </div>
        </div> --}}
    </div>
</div>
