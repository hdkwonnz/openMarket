@extends('layouts.sellerApp')

@section('content')
<div class="container mt-5">

    <edit-products product_id="{{ $productId }}"></edit-products>

</div>
@endsection
