@extends('layouts.app')

@section('title')
{{ config('app.name') }} - My Shopping
@endsection

@section('content')

<div class="container mt-5">
    <order-details></order-details>
</div>
@endsection

@section('extra-js')

@endsection
