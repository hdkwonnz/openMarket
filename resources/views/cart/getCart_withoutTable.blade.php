@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if(Session::has('cart'))
        <div class="row">
            <div class="col-md-10">
                <ul class="list-group">
                    @foreach ($products as $product)
                        <li class="list-group-item">
                            <span>ProductId => {{ $product['productId'] }}</span>
                            <span>Qty => {{ $product['qty'] }}</span>
                            <strong>Name => {{ $product['name'] }}</strong>
                            <span>Price => {{ $product['price'] }}</span>
                            <a href="{{ route('product.deleteInCart', ['id' => $product['productId']]) }}" class="">Delete</a>
                            <a href="{{ route('product.changeInCart', ['id' => $product['productId']]) }}" class="">Change</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('product.deleteAllInCart') }}" class="btn btn-sm btn-danger">Delete All</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <strong>Total: {{ $totalPrice }}</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <button type="button" class="btn btn-success">Checkout</button>
            </div>
        </div>
    @else
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <strong>No Items in Cart!</strong>
        </div>
    </div>
    @endif
</div>
@endsection
