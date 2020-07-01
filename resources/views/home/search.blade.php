@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('myCss/product/product.css') }}">


<!-- current position -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <a href="/">Home</a><span> / </span><span>search</span>
        </div>
    </div>
</div>

<div class="container mt-4">
    @if ($errorMessage)
    <div class="row text-danger mb-5 no-gutters">
        {{ $errorMessage }}
    </div>
    @else
    <div class="row no-gutters">
    @php
        $count = $products->count();
    @endphp
    @if ($count < 1)
    <div class="display-4 mt-5 mb-5">No items on your search.</div>
    @endif
    @foreach ($products as $product)
    <a href="{{ route('product.details', ['id' => $product->id]) }}">
        <div class="categoryb_product_size">
            <div class="categoryb_image_size">
                <img src={{ $product->image_path }} class="img-fluid" alt="">
            </div>
            <div class="product_name_size">
                <div class="line_height13">{{ $product->name }}</div>
            </div>
            @if ($product->price > $product->sale_price)
            <div class="d-flex">
                <div class="mt-2 text-dark mr-3 text_decoration_line_through">${{ $product->price }}</div>
                <div class="mt-2 text-dark"><b>${{ $product->sale_price }}</b></div>
            </div>
            @else
            <div class="mt-2 text-dark"><b>${{ $product->price }}</b></div>
            @endif
            <button type="" class="btn btn-sm btn-success mt-3" onclick="addToCart({{ $product->id }}); return false;">
                Add to Cart
            </button>
            {{-- <a href="{{ route('cart.addToCart', ['id' => $productsCategoryBC->id]) }}" class="btn btn-sm btn-success mt-3">Add to Cart</a> --}}
            {{-- <form action="{{ route('cart.addToCart') }}" method="GET">
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="btn btn-sm btn-success mt-3">Add to Cart</button>
            </form> --}}
        </div>
    </a>
    @endforeach
    </div>
    @endif
</div>
@endsection

@section('extra-js')

<script src="{{ asset('myJs\product\addToCartFromCategory.js') }}"></script>

@endsection
