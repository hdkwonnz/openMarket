@extends('layouts.app')

@section('content')

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
        <div class="col-md-7 col-sm-7">
            <h4>ORDER DETAILS</h4>
        </div>
        <div class="col-md-5 col-sm-5">

        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 col-sm-3">
            <div style="border: 3px solid blue; min-height: 600px; width: 100%;">

            </div>
        </div>
        <div class="col-md-9 col-sm-9">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th style="width: 22%;">Date/Order#</th>
                            <th style="width: 43%;">Product Infos</th>
                            <th style="width: 15%;"></th>
                            <th style="width: 10%;">Delivery</th>
                            <th style="width: 10%;">Review</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td style="width: 20%;" scope="row">
                                <div>
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}
                                </div>
                                <div>Order# : {{ $order->id }}</div>
                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#orderDetailsModal">
                                    Details
                                </a>
                            </td>
                            <td style="width: 80%;">
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                            @foreach ($order->orderdetails as $detail)
                                            <tr>
                                                <td style="width: 20%;">
                                                    <img src={{ $detail->product->image_path }} class="img-fluid img_thumb_nail" alt="">
                                                </td>
                                                <td style="width: 56%;"scope="row">
                                                    <div>{{ $detail->product->name }}</div>
                                                    <div>QTY : {{ $detail->qty }} ea</div>
                                                    <div><b>${{ $detail->sale_price }}</b></div>
                                                </td>
                                                <td style="width: 12%;">
                                                    Lorem ipsum dolor
                                                </td>
                                                <td style="width: 12%;">
                                                    <a href="#" class="btn btn-sm btn-secondary">Write</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>** end of data **</div>
        </div>
    </div><!--end of row-->
</div><!-- end of container -->
@endif

<!-- order deatails modal-->
<div class="modal fade" id="orderDetailsModal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div style="border: 3px solid blue; width: 100%; min-height: 500px;">
                Modal body..
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
</div><!-- end of order deatails modal-->

@endsection
