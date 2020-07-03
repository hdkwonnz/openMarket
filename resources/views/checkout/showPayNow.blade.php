@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <pay-now></pay-now>
</div>
@endsection

@section('extra-js')

<script src="https://js.stripe.com/v3/"></script>

@endsection
