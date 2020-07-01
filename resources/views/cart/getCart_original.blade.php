@extends('layouts.app')

@section('content')
<div class="container">
    @if(Session::has('cart'))
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <ul class="list-group">
                    @foreach ($products as $product)
                        <li class="list-group-item">
                            <span>{{ $product['qty'] }}</span>
                            <strong>{{ $product['item']['name'] }}</strong>
                            <span>{{ $product['price'] }}</span>
                        </li>
                    @endforeach
                </ul>
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
