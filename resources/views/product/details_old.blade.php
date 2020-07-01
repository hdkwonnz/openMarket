@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-4">
            <h2>Product Details</h2>
            {{-- <img class="card-img-top" src="/default-product.jpg" alt="Card image cap"> --}}
            <img class="card-img-top" src="/storage/myImage/groceries/instantFoods/instantRiceCupBob/blackBean.JPG" alt="Card image cap">
            <h4 class="card-title">{{ $product->name }}</h4>
            <p class="card-text">${{ $product->price }}</p>
            <a href="{{ route('cart.addToCart', ['id' => $product->id]) }}" class="btn btn-sm btn-primary">Add to Cart</a>
        </div>
    </div>
</div>
@endsection
