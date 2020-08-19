@extends('layouts.app')

@section('content')

{{-- <link rel="stylesheet" href="{{ asset('myCss/product/product.css') }}"> --}}

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
        <div class="col-md-2 col-sm-2">
            <a href="{{ route('product.details', ['id' => $product->id]) }}" class="text-decoration-none">
                <div class="w-100" style="min-height: 420px;">
                    <div>
                        <img src="{{ $product->image_path }}" class="img-fluid w-100" style="height: 190px;" alt="">
                    </div>
                    <div class="p-2 line_height13" style="height: 130px;">
                        {{ $product->name }}
                    </div>
                    <div class="p-2" style="height: 40px;">
                        @if ($product->price > $product->sale_price)
                        <div class="row">
                            <div class="col-md-3 mt-2 text-dark mr-3 text_decoration_line_through">${{ $product->price }}</div>
                            <div class="col-md-3 mt-2 text-dark"><b>${{ $product->sale_price }}</b></div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-md-12 mt-2 text-dark"><b>${{ $product->price }}</b></div>
                        </div>
                        @endif
                    </div>
                    <div class="mt-4" style="height: 15px;">
                        <button type="" class="btn btn-sm btn-success" onclick="addToCart({{ $product->id }}); return false;">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@section('extra-js')

<script src="{{ asset('myJs\product\addToCartFromCategory.js') }}"></script>

@endsection
