@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h2>Products</h2>
    <div class="row no-gutters">
        @foreach ($allProducts as $product)
        <div class="col-4">
            <div class="card">
                <a href="{{ route('product.details', ['id' => $product->id]) }}">
                    <img class="card-img-top" src="/default-product.jpg" alt="Card image cap">
                </a>
                <div class="card-body">
                    <h4 class="card-title">{{ $product->name }}</h4>
                    <p class="card-text">${{ $product->price }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
