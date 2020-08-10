@extends('layouts.app')

@section('content')

<div class="my_loader">
    <!-- spiner will be showing here -->
</div>

@if ($errorMsg)
<div class="container mt-5 mb-5">
    <div class="row no-gutters">
        <div class="display-4">
            {{ $errorMsg }}
        </div>
    </div>
</div>
@else
<div class="container mt-5">
    <div class="row no-gutters">
        <div class="col-md-2 col-sm-2">
            <h4>ORDER DETAILS</h4>
        </div>
        <div class="col-md-10 col-sm-10">
            <h5 class="text-dark">(Order Number : {{ $order->id }} | Order Date : {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }})</h5>
        </div>
    </col-md-6>
    </div>
    <div class="row mt-2">
        <div class="col-md-9 col-sm-9">
            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Delivery Address / Total Amount</th>
                            <th style="width: 60%;">Product Infos</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td style="width: 40%;" scope="row">
                                <div>{{ $order->addressee }} / {{ $order->address->address }}</div>
                                <div><b>${{ number_format(($order->total_amount),2) }}</b></div>
                            </td>
                            <td style="width: 60%;">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            @foreach ($order->orderdetails as $detail)
                                            <tr>
                                                <td style="width: 20%;">
                                                    <img src={{ $detail->product->image_path }} style="height: 100px; width: 100px;" alt="">
                                                </td>
                                                <td style="width: 80%;"scope="row">
                                                    <div>{{ $detail->product->name }}</div>
                                                    <div>QTY : {{ $detail->qty }} ea</div>
                                                    <div><b>${{ $detail->sale_price }}</b></div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>** end of data **</div>
        </div>
    </div><!--end of row-->
</div><!-- end of container -->
@endif

@endsection

@section('extra-js')
<script src="{{ asset('myJs/layout/loadingSpinner.js') }}"></script>
@endsection
