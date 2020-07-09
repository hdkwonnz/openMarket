<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cerulean/bootstrap.min.css" integrity="sha384-b+jboW/YIpW2ZZYyYdXczKK6igHlnkPNfN9kYAbqYV7rNQ9PKTXlS2D6j1QZIATW" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row no-gutters">
            <div class="col-md-7 col-sm-7">
                <h4>YOUR ORDER DETAILS</h4>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-9 col-sm-9">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 30%;">Date/Order#</th>
                                <th style="width: 43%;">Product Infos</th>
                                <th style="width: 27%;"></th>
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
                                <td style="width: 30%;" scope="row">
                                    <div>
                                        {{ \Carbon\Carbon::parse($orderDetails->created_at)->format('d-m-Y') }}
                                    </div>
                                    <div>Order# : {{ $orderDetails->id }}</div>
                                    <div>{{ $orderDetails->addressee }}/{{ $orderDetails->address->address }}</div>
                                    <div><b>${{ number_format(($orderDetails->total_amount),2) }}</b></div>
                                </td>
                                <td style="width: 80%;">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <tbody>
                                                @foreach ($orderDetails->orderdetails as $detail)
                                                <tr>
                                                    <td style="width: 20%;">
                                                        <img src={{ config('app.url')}}{{ $detail->product->image_path }} style="height: 100px; width: 100px;" alt="">
                                                    </td>
                                                    <td style="width: 56%;"scope="row">
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

</body>
</html>
