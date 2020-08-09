@extends('layouts.app')

@section('title')
{{ config('app.name') }} - {{ $categoryBCs->name }}
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('myCss/product/product.css') }}">

<!-- current position -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <a href="/">Home</a>
            <span> / </span>
            <a href="/product/showProductsCategoryAB/{{ $categoryBCs->categorya->id }}">
                {{ $categoryBCs->categorya->name }}
            </a>
            <span> / </span>
            <span>{{ $categoryBCs->name }}</span>
        </div>
    </div>
</div>

<!-- selected categoryb and categoryc-->
<div class="container mt-4">
    <div class="row no-gutters">
        <div class="col-md-2 col-sm-2">
            <div>
                <h3>{{ $categoryBCs->name }}</h3>
            </div>
            @foreach ($categoryBCs->categorycs as $categoryc)
            <a href="/product/showProductsCategoryC/{{ $categoryc->id }}">
                <div>{{ $categoryc->name }}</div>
            </a>
            @endforeach
        </div>
        <div class="col-md-10 col-sm-10">
            @foreach ($productsCategoryBCs as $productsCategoryBC)
            <a href="{{ route('product.details', ['id' => $productsCategoryBC->id]) }}">
                <div class="categoryb_product_size">
                    <div class="categoryb_image_size">
                        <img src={{ $productsCategoryBC->image_path }} class="img-fluid" alt="">
                    </div>
                    <div class="product_name_size">
                        <div class="line_height13">{{ $productsCategoryBC ->name }}</div>
                    </div>
                    @if ($productsCategoryBC->price > $productsCategoryBC->sale_price)
                    <div class="d-flex">
                        <div class="mt-2 text-dark mr-3 text_decoration_line_through">${{ $productsCategoryBC->price }}</div>
                        <div class="mt-2 text-dark"><b>${{ $productsCategoryBC->sale_price }}</b></div>
                    </div>
                    @else
                    <div class="mt-2 text-dark"><b>${{ $productsCategoryBC->price }}</b></div>
                    @endif
                    <button type="" class="btn btn-sm btn-success mt-3" onclick="addToCart({{ $productsCategoryBC->id }}); return false;">
                        Add to Cart
                    </button>
                    {{-- <a href="{{ route('cart.addToCart', ['id' => $productsCategoryBC->id]) }}" class="btn btn-sm btn-success mt-3">Add to Cart</a> --}}
                    {{-- <form action="{{ route('cart.addToCart') }}" method="GET">
                        <input type="hidden" name="id" value="{{ $productsCategoryBC->id }}">
                        <input type="hidden" name="qty" value="1">
                        <button type="submit" class="btn btn-sm btn-success mt-3">Add to Cart</button>
                    </form> --}}
                </div>
            </a>
            @endforeach

        </div>
    </div>
</div>

@endsection

@section('extra-js')

<script src="{{ asset('myJs\product\addToCartFromCategory.js') }}"></script>

@endsection
