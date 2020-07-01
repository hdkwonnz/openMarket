@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('myCss/home/home.css') }}">

<div class="container" style="margin-top: 34px;">
    <div class="row no-gutters">
        <div class="col-md-3 col-sm-3 z_index2">
            <ul class="list-group">
                {{-- @foreach ($categoryas as $categorya)
                @php
                if (strlen($categorya->name) > 23)
                {
                    $strTemp = "";
                    //$strTemp = substr(($item->title),0, 7); //한글에 문제 있음...
                    $strTemp = mb_substr(($categorya->name),0, 23, "utf-8");
                    $strTemp .= "...";
                    $strTemp;
                }
                else
                {
                    $strTemp = $categorya->name;
                }
                @endphp
                <li class="list-group-item"><h5>{{ $strTemp }}</h5></li>

                <a href="#" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name">
                        <h5>{{ $categorya->name }}</h5>
                    </li>
                </a>
                @endforeach --}}
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name01 category_com01">
                        <h5>Groceries</h5>
                    </li>
                </a>
                <a href="javascript:void(0)" class="text-decoration-none">
                    <li class="list-group-item bg-primary text-white categorya_name02 category_com02">
                        <h5>Meat,Seafood,Produce</h5>
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
        <div class="col-md-9 col-sm-9 category_com01 category_sub01 display_none">
            <div class="row no-gutters mt-3">
                <div class="col-md-6 col-sm-6">
                    @foreach ($categoryas as $categorya)
                    @if ($categorya->id == 1)
                    <div style="width: 260px; float: left; margin-left: 10px;">
                        <a href="#" class="text-dark text-decoration-none">
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
        <div class="col-md-9 col-sm-9 category_com02 category_sub02 display_none">
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
</div>

<!-- big carousel -->
<div class="container-fluid big_carousel">
    <div class="row no-gutters">
        <!-- big carousel  -->
        <div id="homeBig" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ul class="carousel-indicators">
                <li data-target="#homeBig" data-slide-to="0" class="active"></li>
                <li data-target="#homeBig" data-slide-to="1"></li>
                <li data-target="#homeBig" data-slide-to="2"></li>
            </ul>
            <!-- The slideshow -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="\myImage\home\bigCarousel\building-01-1.jpg" class="img-fluid" alt="Los Angeles">
                </div>
                <div class="carousel-item">
                    <img src="\myImage\home\bigCarousel\seoul-01-1.jpg" class="img-fluid" alt="Chicago">
                </div>
                <div class="carousel-item">
                    <img src="\myImage\home\bigCarousel\south-01-1.jpg" class="img-fluid" alt="New York">
                </div>
            </div>
            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#homeBig" data-slide="prev">
                {{-- <span class="carousel-control-prev-icon"></span> --}}
                <i class="fas fa-chevron-left fa-4x"></i>
            </a>
            <a class="carousel-control-next" href="#homeBig" data-slide="next">
                {{-- <span class="carousel-control-next-icon"></span> --}}
                <i class="fas fa-chevron-right fa-4x"></i>
            </a>
        </div><!-- end of big carousel -->
    </div><!-- end of row -->
</div><!-- end of big carousel -->
@endsection

@section('extra-js')
<script src="{{ asset('myJs\home\home.js') }}"></script>
@endsection
