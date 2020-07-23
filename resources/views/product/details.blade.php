@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('myCss/product/details.css') }}">

<!-- current position -->
<div class="container mt-5">
    {{-- <div class="row">
        @if (session('message'))
        <div class="alert alert-success display-4">
            {{ session('message') }}
        </div>
        @endif
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <a href="/">Home</a>
            <span> / </span>
            <a href="/product/showProductsCategoryAB/{{ $product->categorya->id }}">
                {{ $product->categorya->name }}
            </a>
            <span> / </span>
            <a href="/product/showProductsCategoryBC/{{ $product->categoryb_id }}">{{ $product->categoryb->name }}</a>
            </span> / <span>
            <a href="/product/showProductsCategoryC/{{ $product->categoryc->id }}">
                <span>{{ $product->categoryc->name }}</span>
            </a>
            <span> / </span>
            </span>{{ $product->name }}span
        </div>
    </div>
</div>

<!-- product contents -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-5">
            <img src={{ $product->image_path }} class="img-fluid details_image_size" alt="">
        </div>
        <div class="col-md-7">
            <div class="mt-4">
                <h4>{{ $product->name }}({{ $product->id }})</h4>
            </div>
            @if ($product->price > $product->sale_price)
            <div class="d-flex">
                <div class="mt-4 text-dark mr-3 text_decoration_line_through"><h4>${{ $product->price }}</h4></div>
                <div class="mt-4 text-dark"><h4><b>${{ $product->sale_price }}</b></h4></div>
            </div>
            @else
            <div class="mt-4 text-dark"><b>${{ $product->price }}</b></div>
            @endif
            <div class="mt-4">
                <h5>INFO</h5>
                {{ $product->info }}
            </div>
            <div class="mt-4">
                <h5>QTY</h5>
            </div>
            <!-- https://bootsnipp.com/snippets/2eKOz -->
            <form class="add_cart">
                <input type="hidden" name="id" class="product_id" value="{{ $product->id }}">
                <div class="plus_minus qty_dummy mt-1">
                    <span class="span_span minus bg-dark">-</span>
                    <input type="number" class="input_input count" name="dummy_not_used" value="1">
                    <input type="hidden" name="qty" value="" class="qty_real">
                    <span class="span_span plus bg-dark">+</span>
                </div>
                <div class= "mt-4">
                    <button type="" class="btn btn-sm btn-primary py-auto"><h4>Add to Cart</h4></button>
                </div>
            </form>
            {{-- <form action="{{ route('cart.addToCart') }}" method="GET">
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="plus_minus qty_dummy mt-1">
                    <span class="span_span minus bg-dark">-</span>
                    <input type="number" class="input_input count" name="dummy_not_used" value="1">
                    <input type="hidden" name="qty" value="" class="qty_real">
                    <span class="span_span plus bg-dark">+</span>
                </div>
                <div class= "mt-4">
                    <button type="submit" class="btn btn-sm btn-primary py-auto"><h4>Add to Cart</h4></button>
                </div>
            </form> --}}
        </div>
    </div>

    <div class="row no-gutters mt-5">
        <div class="col-md-12 col-sm-12">
            <div><h5><b>Item Details</b></h5></div>
            <hr>
        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-md-2 col-sm-2">
            <b>Product Name</b>
        </div>
        <div class="col-md-10 col-sm-10">
            {{ $product->name }}
        </div>
        <div class="col-md-2 col-sm-2">
            <b>SKU</b>
        </div>
        <div class="col-md-10 col-sm-10">
            {{ $product->sku }}
        </div>
        <div class="col-md-2 col-sm-2">
            <b>Country of Origin</b>
        </div>
        <div class="col-md-10 col-sm-10">
            {{ $product->country_origin }}
        </div>
        <div class="col-md-2 col-sm-2">
            <b>Brand</b>
        </div>
        <div class="col-md-10 col-sm-10">
            {{ $product->brand }}
        </div>
        <div class="col-md-2 col-sm-2">
            <b>Net Wt.</b>
        </div>
        <div class="col-md-10 col-sm-10">
            {{ $product->weight }}
        </div>
        <div class="col-md-2 col-sm-2">
            <b>Ingredients</b>
        </div>
        <div class="col-md-10 col-sm-10">
            {{ $product->ingredients }}
        </div>
        <div class="col-md-2 col-sm-2">
            <b>Nutrition Facts</b>
        </div>
        <div class="col-md-10 col-sm-10">
            {{ $product->nutrition_facts }}
        </div>
    </div>

    <div class="row no-gutters mt-5">
        <div class="col-md-12 col-sm-12">
            <div><h5><b>Product Description</b></h5></div>
            <hr>
        </div>
    </div>

</div>
@endsection

@section('extra-js')

<script src="{{ asset('myJs\product\details.js') }}"></script>
<script src="{{ asset('myJs\product\addToCart.js') }}"></script>

@endsection
