<div class="container-fluid">
    <div class="col-md-8 col-sm-8" style="position: fixed; left: 10px; bottom: 0px; z-index: 4;">
        @php
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
        @endphp

        @if ($count > 0)
            <!-- 어레이에 저장된 내용을 역순으로 읽어 맨 끝 내용이 맨 앞으로 오게 한다. -->
            @for ($ii = $ix; $ii >= 0; $ii--)
            <div class="display_none show_watched" style="width: 100px; height: 100px; float: left;">
                {{-- <a href="javascript: void(0)" onclick="event.preventDefault(); details({{ $products[$ii]['pId'] }});">
                    <img src={{ $products[$ii]['fName'] }} class="img-fluid img_thumb_nail" alt="">
                </a> --}}
                <a class="show_image" href="{{ route('product.details', ['id' => $products[$ii]['pId']]) }}" target="_blank">
                    <img src={{ $products[$ii]['fName'] }} class="img-fluid img_thumb_nail" alt="">
                </a>
                {{-- <a href="javascript: void(0)" onclick="event.preventDefault(); deleteRecall({{ $products[$ii]['pId'] }});">
                    <span class="text-white">X</span>
                </a> --}}
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
        @endif
    </div>
</div>
