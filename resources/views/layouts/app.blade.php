<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title')</title>

    <!-- favicon for logo to add title block-->
    <link rel="icon" href="/myImages/logo/favicon.ico" type = "image/x-icon" sizes="16x16">

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('myCss/layout/app.css') }}">

</head>
<body>
    <div id="app">
        <!-- navbar top -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/myImages/logo/logo.png" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="javascript: void(0)" class="nav-link all_menu">
                                <i class="fas fa-bars fa-2x bars_img"></i>
                                <i class="fas fa-times fa-2x display_none cross_img"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- Search --> <!-- do not delete below -->
                    {{-- <form class="form-inline mr-auto" action="/home/search" method="GET" name="mainSerach" id="mainSerach">
                        <input type="text" class="form-control" style="width: 400px;" name="searchTerm" id="searchTerm" value="{{ request()->input('searchTerm') }}" placeholder="Search" aria-label="Search" required autofocus />
                        <button class="btn btn-outline-success" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form> --}}
                    <!-- https://www.codeply.com/go/sbfCXYgqoO -->
                    <form class="mx-2 my-auto d-inline w-25" action="/home/search" method="GET" name="mainSerach" id="mainSerach">
                        <div class="input-group">
                            <input type="text" class="form-control border border-right-0" name="searchTerm" id="searchTerm" value="{{ request()->input('searchTerm') }}" placeholder="Search" aria-label="Search" required autofocus>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary border border-left-0" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="{{ route('order.orderDetails') }}" class="nav-link text-dark" href="#">MY SHOPPING</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark watched_products" href="javascript: void(0)">VIEWED</a>
                        </li>
                        <li class="nav-item">
                            {{-- <a class="nav-link m-0 p-0" href="{{ route('cart.showCart') }}">
                                <i class="fas fa-cart-arrow-down text-primary fa-2x"></i>
                                <span class="badge badge-danger count_cart">{{ Session::get('cart') ? Session::get('cart')->countOfItems : 0 }}</span>
                            </a> --}}
                            <a class="nav-link text-dark" href="{{ route('cart.showCart') }}">
                                CART<span class="badge badge-danger count_cart">{{ Session::get('cart') ? Session::get('cart')->countOfItems : 0 }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav><!-- end of navbar top -->

        <!-- navbar second top-->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="top: 60px; z-index: 3;">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    @cannot('isAdminOrSeller')
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">ABOUT US</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">CONTACT US</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('location.index') }}">LOCATION & HOURS</a>
                        </li>
                    </ul>
                    @endcannot

                    @cannot('isAdminOrSeller')
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('login') }}">
                                <!-- <i class="fas fa-sign-in-alt text-primary"></i> --> LOGIN
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('register') }}">
                                    <!-- <i class="fas fa-user-plus text-primary"></i> --> REGISTER
                                </a>
                            </li>
                        @endif
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user text-primary text-dark"></i> {{ Auth::user()->name }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <!-- <i class="fas fa-sign-out-alt text-danger"></i> --> LOGOUT
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        @endguest
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">CUSTOMER CENTER</a>
                        </li>
                    </ul>
                    @endcannot
                </div>
            </div>
        </nav><!-- end of navbar second top-->

        <!-- dummy element for goTop a tag -->
        <div class="base_mark"></div>

        <!-- all menu display block -->
        <div class="container">
            <div class="all_category z_index3 display_none position_absolute_top bg-white">

            </div>
        </div>

        @cannot('isAdminOrSeller')

        <!-- main contents -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- footer -->
        @include('includes.layout.app.footer')
        <!-- goTop -->
        @include('includes.layout.app.goTop')
        <!-- help -->
        @include('includes.layout.app.help')
        <!-- view watched product-->
        @include('includes.layout.app.reCall')

        @endcannot

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('myJs/layout/app.js') }}"></script>
    <script src="{{ asset('myJs/layout/reCall.js') }}"></script>

    @yield('extra-js')

</body>
</html>
