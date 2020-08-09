@extends('layouts.app')

@section('title')
{{ config('app.name') }} - MY Cart
@endsection

@section('content')

<div class="container mt-5">
    <get-cart></get-cart>
</div>
@endsection

@section('extra-js')

@endsection
