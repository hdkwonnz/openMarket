@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('myCss/order/order.css') }}">

<div class="container mt-5">
    @if ($errorMsg)
    <div class="row no-gutters">
        <div class="col-md-12 col-sm-12">
            <div class="display-4 mb-5">
                {{ $errorMsg }}
            </div>
        </div>
    </div>

    @else
    <div class="row no-gutters mb-4">
        <div class="bg-info text-center" style="border: 1px solid black; min-height: 80px; width: 100%; padding-top: 20px;">
            <h2>PAYMENT INFORMATIONS</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div>
                <h4>Delivery address</h4>
            </div>
            <div style="border: 1px solid blue; width: 100%; height: 159px;">

            </div>
            <div class="mt-4">
                <h4>Terms and Conditions</h4>
            </div>
            <div style="border: 1px solid blue; width: 100%; height: 150px;">

            </div>
            <div class="mt-4">
                <h4>Payment method</h4>
            </div>
            <div style="border: 1px solid blue; width: 100%; height: 140px;">

            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div>
                <h4>Products of your order</h4>
            </div>
            <div style="border: 1px solid blue; height: 300px; overflow-y: scroll;">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td scope="row" style="width: 20%;">
                                    <a href="{{ route('product.details', ['id' => $product['productId']]) }}" target="_blank">
                                        <img src={{ $product['imagePath'] }} class="img-fluid img_thumb_nail" alt="">
                                    </a>
                                </td>
                                <td style="width: 80%;">
                                    <a href="{{ route('product.details', ['id' => $product['productId']]) }}" target="_blank" class="text-decoration-none text-dark">
                                        <div style="min-height: 80px;">
                                            {{ $product['name'] }}({{ $product['productId'] }})
                                        </div>
                                        <div class="d-flex" style="min-height: 20px;">
                                            @if ($product['price'] > $product['salePrice'])
                                            <div class="d-flex">
                                                <div class="text-dark mr-3 text_decoration_line_through">${{ $product['price'] }}</div>
                                                <div class="text-dark"><b>${{ $product['salePrice'] }}</b></div>
                                            </div>
                                            @else
                                            <div class="d-flex">
                                                <div class="text-dark"><b>${{ $product['price'] }}</b></div>
                                            </div>
                                            @endif
                                            <div> &nbsp;/&nbsp;</div>
                                            <div>{{ $product['qty'] }} ea</div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td scope="row" colspan="2" class="text-center">
                                    <span><h5>{{ $count }} item(s)</h5></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="mt-4">
                <h4>Payment informations</h4>
            </div>
            <div style="border: 3px solid blue; min-height: 206px;">
                <div class="d-flex mt-2 mx-2">
                    <div class="w-50"><h4>Total Price</h4></div>
                    <div class="w-50 text-right"><h4>${{ number_format($totalPrice,2) }}</h4></div>
                </div>
                <div class="d-flex mt-2 mx-2">
                    <div class="w-50"><h4>Total Discounted</h4></div>
                    <div class="w-50 text-right"><h4>${{ number_format(($totalPrice - $totalSalePrice),2) }}</h4></div>
                </div>
                <div class="d-flex mt-2 mx-2">
                    <div class="w-50"><h4>Shipping Charge</h4></div>
                    <div class="w-50 text-right"><h4>$10.00</h4></div>
                </div>
                <div class="d-flex mt-2 mx-2">
                    <div class="w-50"><h4>Grand Total</h4></div>
                    <div class="w-50 text-right"><h4>${{ number_format(($totalSalePrice + 10),2) }}</h4></div>
                </div>
                <a href="javascript:void(0) return false;" class="text-decoration-none click_pay">
                    <div class="text-center bg-primary text-white" style="border: none; height: 40px; padding-top: 5px;">
                        <h4>Click to Pay</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('extra-js')

<script src="{{ asset('myJs\checkOut\checkOut.js') }}"></script>

@endsection
