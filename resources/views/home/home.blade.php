@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('myCss/home/home.css') }}">

<!-- categorya & categoryb -->
<div class="container" style="margin-top: 35px;">
    <div class="row no-gutters">
        <div class="col-md-5 col-sm-6 col-lg-4 col-xl-3 z_index2">
            <ul class="list-group">
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name01 category_com01">
                        <h5>Groceries</h5>
                    </li>
                </a>
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name02 category_com02">
                        <h5>Meat, Seafood, Produce</h5>
                    </li>
                </a>
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name">
                        <h5>Dairy, Refrigerated Foods</h5>
                    </li>
                </a>
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name">
                        <h5>Frozen Foods</h5>
                    </li>
                </a>
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name">
                        <h5>Miscellaneous Foods</h5>
                    </li>
                </a>
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name">
                        <h5>Health</h5>
                    </li>
                </a>
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name">
                        <h5>Beauty</h5>
                    </li>
                </a>
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name">
                        <h5>Home & Kitchen</h5>
                    </li>
                </a>
            </ul>
        </div>

        <!-- groceries -->
        <div class="col-lg-8 col-xl-9 col-md-7 col-sm-6 category_com01 category_sub01 display_none">
            <div class="row no-gutters mt-3">
                <div class="col-md-6 col-sm-6">
                    @foreach ($categoryas as $categorya)
                    @if ($categorya->id == 1)
                    <div style="width: 260px; float: left; margin-left: 10px;">
                        <a href="/product/showProductsCategoryAB/{{ $categorya->id }}" class="text-decoration-none text-dark">
                            <h4>
                                <b>{{ $categorya->name }}</b>
                            </h4>
                        </a>
                        @foreach ($categorya->categorybs as $item)
                        <div class="ml-3">
                            <a href="/product/showProductsCategoryBC/{{ $item->id }}" class="text-decoration-none"><h5>{{ $item->name }}</h5></a>
                        </div>
                        @endforeach
                    </div>
                    @break
                    @endif
                    @endforeach
                </div>
                <div class="col-md-6 col-sm-6">
                    <img class="img-fluid" src="/default-product.jpg" alt="">
                </div>
            </div>
        </div>

        <!-- meat seafood produce -->
        <div class="col-lg-9 col-xl-9 col-md-9 col-sm-9 category_com02 category_sub02 display_none">
            @foreach ($categoryas as $categorya)
            @if ($categorya->id == 2)
            <div style="width: 260px; float: left; margin-left: 10px;">
                <b>{{ $categorya->name }}</b> <br>
                @foreach ($categorya->categorybs as $item)
                    <div>{{ $item->name }}</div>
                @endforeach
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div><!-- end of categorya & categoryb -->

<!-- top big carousel -->
<div class="container-fluid big_carousel">
    <div class="row">
        <div id="homeBig" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ul class="carousel-indicators">
                <li data-target="#homeBig" data-slide-to="0" class="active"></li>
                <li data-target="#homeBig" data-slide-to="1"></li>
                <li data-target="#homeBig" data-slide-to="2"></li>
            </ul>
            <!-- The slideshow -->
            <div class="carousel-inner">
                @foreach($carouselones as $key => $product)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <a href="{{ route('product.details', ['id' => $product->product_id]) }}">
                        <img style="min-height: 445px;" src="{{ $product->image_path }}" class="img-fluid d-block w-100" alt="Los Angeles">
                    </a>
                </div>
                @endforeach
            </div>
            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#homeBig" data-slide="prev">
                <i class="fas fa-chevron-left fa-4x"></i>
            </a>
            <a class="carousel-control-next" href="#homeBig" data-slide="next">
                <i class="fas fa-chevron-right fa-4x"></i>
            </a>
        </div>
    </div><!-- end of row -->
</div><!-- end of top big carousel -->

<!-- BEST PRODUCTS IN THIS WEEK -->
<!-- https://stackoverflow.com/questions/55481009/in-bootstrap-4-multiple-item-slider-3-items-shows-at-the-same-time-on-desktop -->
<!--아래 오른쪽 data-interval을 "0"으로 놓으면 자동 sliding이 없어진다.-->
<!--2초마다 슬라이딩 원할시 "2000"을 넣는다.-->
<div class="container mt-4">
    <span><h5><b>BEST PRODUCTS IN THIS WEEK</b></h5></span>
    <div id="best_products_carousel" class="carousel slide multi_items_carousel" data-ride="carousel" data-interval="2000">
        <!-- slide -->
        <div class="carousel-inner">
            @foreach($bestProducts as $key => $product)
            @php
                $remainder = fmod($key,6);
            @endphp
            @if ($remainder == 0)
            <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                <div class="row no-gutters">
                    <div class="col-sm-2 col-md-2">
                        <a href="{{ route('product.details', ['id' => $product->id]) }}" class="text-decoration-none text-dark">
                            <div class="card" style="width: 201px; height: 310px;">
                                <div style="width: 193px; height: 180px;">
                                    <img class="card-img-top" src="{{ $product->image_path }}" alt="">
                                </div>
                                <div style="width: 193px; height: 100px;">
                                    <div class="card-body">
                                        <div style="width: 193px; height: 80px; padding-right: 30px;">
                                            <p class="card-title" style="word-break: break-all;">{{ $product->name }}</p>
                                        </div>
                                        <p class="card-text"><b>${{ $product->price }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            @else
                    <div class="col-sm-2 col-md-2">
                        <a href="{{ route('product.details', ['id' => $product->id]) }}" class="text-decoration-none text-dark">
                            <div class="card" style="width: 201px; height: 310px;">
                                <div style="width: 193px; height: 180px;">
                                    <img class="card-img-top" src="{{ $product->image_path }}" alt="">
                                </div>
                                <div style="width: 193px; height: 100px;">
                                    <div class="card-body">
                                        <div style="width: 193px; height: 80px; padding-right: 30px;">
                                            <p class="card-title" style="word-break: break-all;">{{ $product->name }}</p>
                                        </div>
                                        <p class="card-text"><b>${{ $product->price }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @if ($remainder == 5)
                </div><!-- end of row -->
            </div><!-- end of carousel item -->
                @endif
            @endif
            @endforeach
        </div><!-- end of slid -->

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#best_products_carousel" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#best_products_carousel" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div><!-- end of id="best_products_carousel" -->
</div><!-- END OF BEST PRODUCTS IN THIS WEEK -->

<!-- HOT PRODUCTS-->
<div class="container mt-4">
    <span><h5><b>HOT PRODUCTS</b></h5></span>
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <div class="bg-warning mb-3" style="border: 1px solid red; height: 200px;">

            </div>
            <div class="bg-warning" style="border: 1px solid red; height: 200px;">

            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="bg-info mb-3" style="border: 1px solid red; height: 415px;">

            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="bg-success mb-3" style="border: 1px solid red; height: 200px;">

            </div>
            <div class="bg-success" style="border: 1px solid red; height: 200px;">

            </div>
        </div>
    </div>
</div><!-- END OF HOT PRODUCTS-->

<!-- new arrivals carousel-->
<div class="container mt-4">
    <span><h5><b>NEW ARRIVALS</b></h5></span>
    <div id="new_arrivals_carousel" class="carousel slide multi_items_carousel" data-ride="carousel" data-interval="2500">
        <!-- slide -->
        <div class="carousel-inner">
            @foreach($newArrivalProducts as $key => $product)
            @php
                $remainder = fmod($key,6);
            @endphp
            @if ($remainder == 0)
            <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                <div class="row no-gutters">
                    <div class="col-sm-2 col-md-2">
                        <a href="{{ route('product.details', ['id' => $product->id]) }}" class="text-decoration-none text-dark">
                            <div class="card" style="width: 201px; height: 310px;">
                                <div style="width: 193px; height: 180px;">
                                    <img class="card-img-top" src="{{ $product->image_path }}" alt="">
                                </div>
                                <div style="width: 193px; height: 100px;">
                                    <div class="card-body">
                                        <div style="width: 193px; height: 80px; padding-right: 30px;">
                                            <p class="card-title" style="word-break: break-all;">{{ $product->name }}</p>
                                        </div>
                                        <p class="card-text"><b>${{ $product->price }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            @else
                    <div class="col-sm-2 col-md-2">
                        <a href="{{ route('product.details', ['id' => $product->id]) }}" class="text-decoration-none text-dark">
                            <div class="card" style="width: 201px; height: 310px;">
                                <div style="width: 193px; height: 180px;">
                                    <img class="card-img-top" src="{{ $product->image_path }}" alt="">
                                </div>
                                <div style="width: 193px; height: 100px;">
                                    <div class="card-body">
                                        <div style="width: 193px; height: 80px; padding-right: 30px;">
                                            <p class="card-title" style="word-break: break-all;">{{ $product->name }}</p>
                                        </div>
                                        <p class="card-text"><b>${{ $product->price }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @if ($remainder == 5)
                </div><!-- end of row -->
            </div><!-- end of carousel item -->
                @endif
            @endif
            @endforeach
        </div><!-- end of slid -->

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#new_arrivals_carousel" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#new_arrivals_carousel" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div><!--/.Carousel Wrapper-->
</div><!-- end of new arrivals carousel -->

<!-- super deal -->
<div class="container-fluid mt-4">
    <div class="row">
        <div style="border: 1px solid gold; width: 100%; height: 300px; background-color: gold;">
            <div class="container">
                <div class="row no-gutters">
                    <div style="margin-top: 20px;">
                        <h2>
                            <span class="text-white bg-danger">Super Deal <i class="far fa-lightbulb"></i></span>
                        </h2>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-md-4 col-sm-4 col-4">
                        <div style="border: 1px solid white; height: 400px; background-color: red; position:relative; top: 10px;">

                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-4">
                        <div style="border: 1px solid white; height: 400px; background-color: red; position:relative; top: 10px;">

                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-4">
                        <div style="border: 1px solid white; height: 400px; background-color: red; position:relative; top: 10px;">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end of row -->

    <!-- duumy block -->
    <div class="row">
        <div style="height: 160px; width: 100%;">

        </div>
    </div><!-- end of duumy block -->

</div><!-- end of super deal -->

<!-- FRESH VEGES FROM THE FARM -->
<div class="container mt-5">
    <div class="row no-gutters">
        <h5><b>FRESH VEGES FROM THE FARM</b></h5>
    </div>
    <div class="row no-gutters mt-2">
        <div class="bg-primary" style="border: 1px solid white; width: 100%; height: 400px;">

        </div>
    </div>
</div><!-- end of FRESH VEGES FROM THE FARM -->

<!-- home shopping event -->
<div class="container mt-4">
    <div class="row no-gutters">
        <h5><b>HOME SHOPPING EVENTS</b></h5>
    </div>
</div>
<div class="container-fluid mt-2">
    <div class="row" style="background-color: rgba(41, 40, 37, 0.068);">
        <div class="container">

            <div class="row no-gutters">
                <!--Carousel Wrapper-->
                <div id="home_shopping_event" class="carousel slide carousel-multi-item" data-ride="carousel" data-interval="2000">
                    <!--Indicators-->
                    <ol class="carousel-indicators">
                        <li data-target="#home_shopping_event" data-slide-to="0" class="active"></li>
                        <li data-target="#home_shopping_event" data-slide-to="1"></li>
                        <li data-target="#home_shopping_event" data-slide-to="2"></li>
                        <li data-target="#home_shopping_event" data-slide-to="3"></li>
                        <li data-target="#home_shopping_event" data-slide-to="4"></li>
                        <li data-target="#home_shopping_event" data-slide-to="5"></li>
                    </ol><!--/.Indicators-->
                    <!--Slides-->
                    <div class="carousel-inner" role="listbox">
                        @foreach($bestProducts as $key => $product)
                        @php
                            $remainder = fmod($key,6);
                        @endphp
                        @if ($remainder == 0)
                        <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                            <div class="row no-gutters">
                                <div class="col-md-2">
                                    <a href="{{ route('product.details', ['id' => $product->id]) }}" class="text-decoration-none text-dark">
                                        <div class="card" style="width: 201px; height: 310px;">
                                            <div style="width: 193px; height: 180px;">
                                                <img class="card-img-top" src="{{ $product->image_path }}" alt="">
                                            </div>
                                            <div style="width: 193px; height: 100px;">
                                                <div class="card-body">
                                                    <div style="width: 193px; height: 80px; padding-right: 30px;">
                                                        <p class="card-title" style="word-break: break-all;">{{ $product->name }}</p>
                                                    </div>
                                                    <p class="card-text"><b>${{ $product->price }}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                        @else
                                <div class="col-md-2 clearfix d-none d-md-block">
                                    <a href="{{ route('product.details', ['id' => $product->id]) }}" class="text-decoration-none text-dark">
                                        <div class="card" style="width: 201px; height: 310px;">
                                            <div style="width: 193px; height: 180px;">
                                                <img class="card-img-top" src="{{ $product->image_path }}" alt="">
                                            </div>
                                            <div style="width: 193px; height: 100px;">
                                                <div class="card-body">
                                                    <div style="width: 193px; height: 80px; padding-right: 30px;">
                                                        <p class="card-title" style="word-break: break-all;">{{ $product->name }}</p>
                                                    </div>
                                                    <p class="card-text"><b>${{ $product->price }}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @if ($remainder == 5)
                            </div><!-- end of row -->
                        </div><!-- end of carousel item -->
                            @endif
                        @endif
                        @endforeach

                    </div><!--/.Slides-->
                     <!-- Left and right controls -->
                     {{-- <div>
                        <a class="carousel-control-prev" href="#home_shopping_event" data-slide="prev">
                            <i class="fas fa-chevron-left fa-2x"></i>
                        </a>
                        <a class="carousel-control-next" href="#home_shopping_event" data-slide="next">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </a>
                     </div> --}}
                </div><!--/.Carousel Wrapper-->
            </div><!-- end of row -->
        </div>
    </div>
</div><!-- end of home shopping event -->

<!-- others -->
<div class="container mt-5">
    <div class="row no-gutters">
        <h5><b>OTHERS</b></h5>
    </div>
    <div class="row no-gutters mt-2">
        <div class="bg-secondary" style="border: 1px solid white; width: 100%; height: 400px;">

        </div>
    </div>
</div><!-- end of others -->

<!-- pop up modal-->
<div class="modal fade noticeModal-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- modal header -->
            <div class="modal-header">
                <div class="offset-md-5 col-md-3">
                    <h4 class="modal-title" id="exampleModalLabel">Header Title</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div><!-- end of modal header -->
            <!-- modal body -->
            <div class="modal-body">
                <div class="modal_body_border">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis possimus ex adipisci placeat optio fuga quas, veniam doloremque! Sed ipsam architecto voluptatibus ut dolores quam accusamus sit atque possimus nam, commodi tenetur, aperiam officia assumenda veniam consequatur? Voluptatibus nostrum quidem consectetur corporis ut illo amet sed nam fugiat repellat dolore saepe nihil ratione, facilis consequuntur deserunt quisquam suscipit accusantium eius porro error sequi voluptates. Rerum illo corrupti optio itaque. Enim sunt hic obcaecati maiores quibusdam similique? Eveniet, facere distinctio. Enim, sunt corporis dolores nulla modi aliquam voluptatem consequatur numquam unde quam iste minus animi sit id! Magni sunt iste voluptatem, quam nobis a. Impedit aliquam cum at exercitationem, nobis, voluptas explicabo expedita non molestias alias architecto veritatis fugiat reprehenderit vero earum sed maiores deserunt adipisci ut. Cumque ipsam placeat itaque vero at voluptatum magnam, quidem omnis ipsa ab dicta? Pariatur aliquid quam cupiditate hic quidem quos aliquam repudiandae exercitationem magnam nostrum recusandae, assumenda eum dolorem nihil veniam quae perferendis cumque ducimus minima tenetur magni odit? Numquam nesciunt non ipsum consequatur illum assumenda laudantium facilis doloremque cum, pariatur et voluptas. Officiis illum neque magnam facere ut minima hic aut doloremque placeat sit, ratione sapiente rem natus consectetur, odio soluta id cum! Placeat dignissimos, facilis rem quo commodi eos eum? Ipsum corrupti laudantium consectetur eius. Eos beatae repudiandae, nisi quaerat vitae tempore odit, aspernatur repellat quas minima necessitatibus aperiam optio nulla quidem sapiente harum veniam in repellendus et mollitia. Nihil expedita a dolorem aspernatur aliquid cum. Odit ipsam, suscipit perspiciatis aut voluptates magnam beatae quasi labore delectus nam consequatur minima nobis dolorum magni aliquam eaque aliquid quam nesciunt aperiam dolor natus nulla rem! Placeat porro itaque accusantium ratione ut nulla nemo, architecto modi nostrum autem eum doloremque expedita blanditiis suscipit consequuntur necessitatibus quaerat. Atque officiis, neque cumque soluta similique id fugit mollitia in exercitationem doloribus numquam non laborum provident accusamus temporibus ut hic sed praesentium iste! Deleniti eos dolor perspiciatis tenetur dicta natus neque consectetur, illum nam nihil, recusandae placeat animi nostrum aperiam laboriosam voluptatibus nesciunt laborum beatae a? Quas doloremque sapiente tempora qui, optio delectus modi enim neque incidunt ipsa culpa sequi quidem consequuntur sunt deleniti eum similique voluptatum cupiditate error atque reiciendis repellat necessitatibus eius! Ex earum quis maiores, temporibus voluptas perferendis. Atque nemo rerum placeat, illo quo rem ipsam vero dolores suscipit eligendi impedit alias exercitationem, nulla libero, similique delectus officia natus doloremque provident illum ea sit ad voluptatibus.</p>

                </div>
            </div><!-- end of modal body -->
            <!-- modal footer -->
            <div class="modal-footer">
                <div class="row form-group">
                    <label for="todayClose" class="col-form-label col-md-7 col-sm-7 col-7 text-right"><strong>No show today</strong></label>
                    <div class="col-md-3 col-sm-3 col-3">
                        <input type="checkbox" name="todayClose" class="todayClose form-control">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div> <!-- end modal footer -->
        </div>
    </div>
</div> <!-- end of pop up modal -->

@endsection

@section('extra-js')
<script src="{{ asset('myJs/home/home.js') }}"></script>
@endsection
