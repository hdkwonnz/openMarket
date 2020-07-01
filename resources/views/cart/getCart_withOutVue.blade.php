@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if(Session::has('cart'))
    <div class="row no-gutters">
        <div class="col-md-12 col-sm-12">
            <h2>My Cart</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th></th> <!-- picture -->
                        <th>U/Price</th>
                        <th>Sale</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td scope="row" style="width: 35%;">{{ $product['name'] }}({{ $product['productId'] }})</td>
                        <td style="width: 10%;"><img src={{ $product['imagePath'] }} class="img-fluid" style="width: 100px; height: 100px;" alt=""></td>
                        <td style="width: 10%;">
                            @php
                                $editedPrice = number_format($product['price'],2)
                            @endphp
                            ${{ $editedPrice }}
                        </td>
                        <td style="width: 10%;">
                            @php
                                $editedSalePrice = number_format($product['salePrice'],2)
                            @endphp
                            ${{ $editedSalePrice }}
                        </td>
                        <td style="width: 15%;">
                            <form action="{{ route('cart.changeInCart', $product['productId']) }}">
                                <input type="number" name="qty" min="1" max="50" value="{{ $product['qty'] }}">
                                <button type="submit" class="btn btn-sm btn-primary">Edit</button>
                            </form>
                        </td>
                        <td style="width: 10%;">
                            @php
                                $editedTotal = number_format(($product['qty'] * $product['price']),2)
                            @endphp
                            ${{ $editedTotal }}
                        </td>
                        <td style="width: 10%;">
                            <a href="{{ route('cart.deleteInCart', ['id' => $product['productId']]) }}" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><a href="{{ route('cart.deleteAllInCart') }}" class="btn btn-sm btn-danger">Delete All</a></td>
                    </tr>
                    <tr>
                        <td><strong>G/Total</strong></td>
                        <td></td>
                        <td>
                            @php
                            $editedTotalPrice = number_format($totalPrice,2)
                            @endphp
                            <strong>${{$editedTotalPrice }}</strong>
                        </td>
                        <td>
                            @php
                            $editedSaleTotalPrice = number_format($totalSalePrice,2)
                            @endphp
                            <strong>${{$editedSaleTotalPrice }}</strong>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><button type="button" class="btn btn-lg btn-success">Checkout</button></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6">
            @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <strong class="display-4">No Items in Cart!</strong>
        </div>
    </div>
    @endif
</div>
@endsection
