@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row no-gutter">
        <div class="col-md-2">
            {{-- <ul class="list-group">
                @foreach ($categoryas as $categorya)
                @php
                if (strlen($categorya->name) > 15)
                        {
                            $strTemp = "";
                            //$strTemp = substr(($item->title),0, 7); //한글에 문제 있음...
                            $strTemp = mb_substr(($categorya->name),0, 15, "utf-8");
                            $strTemp .= "...";
                            $strTemp;
                        }
                        else
                        {
                            $strTemp = $categorya->name;
                        }
                    @endphp
                <li class="list-group-item"><h5>{{ $strTemp }}</h3></li>
                @endforeach
            </ul> --}}

            @foreach ($categoryas as $categorya)
                <div class="{{ $categorya->name }}">
                    @php
                        if (strlen($categorya->name) > 15)
                                {
                                    $strTemp = "";
                                    //$strTemp = substr(($item->title),0, 7); //한글에 문제 있음...
                                    $strTemp = mb_substr(($categorya->name),0, 15, "utf-8");
                                    $strTemp .= "...";
                                    $strTemp;
                                }
                                else
                                {
                                    $strTemp = $categorya->name;
                                }
                    @endphp
                    <h5>{{ $strTemp }}</h5>
                </div>
                @foreach ($categorya->categorybs as $categoryb)
                <div class="{{ $categorya->name }}">
                    {{ $categoryb->name }}
                </div>
                @endforeach
            @endforeach
        </div>
        <div class="col-md-10">
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
                    <img src="\myImage\home\bigCarousel\ca-01.JPG" class="img-responsive-responsive" alt="Los Angeles">
                  </div>
                  <div class="carousel-item">
                    <img src="\myImage\home\bigCarousel\ca-02.JPG" class="img-responsive-responsive" alt="Chicago">
                  </div>
                  <div class="carousel-item">
                    <img src="\myImage\home\bigCarousel\ca-03.JPG" class="img-responsive-responsive" alt="New York">
                  </div>
                </div>
                <!-- Left and right controls -->
                {{-- <a class="carousel-control-prev" href="#homeBig" data-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#homeBig" data-slide="next">
                  <span class="carousel-control-next-icon"></span>
                </a> --}}
              </div><!-- end of big carousel -->
        </div>
    </div>
</div>
@endsection
