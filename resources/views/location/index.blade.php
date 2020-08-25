@extends('layouts.app')

@section('title')
{{ config('app.name') }} - Shop Location
@endsection

@section('content')
{{-- https://laraveldaily.com/laravel-find-addresses-with-coordinates-via-google-maps-api/ --}}
<div class="container mt-5">
    <div class="row">
        <div class="col-md-7 col-sm-7">
            <h4>Shop location</h4>
            <form>
                <div class="form-group">
                    {{-- <label for="address_address">Address</label> --}}
                    {{-- <input type="text" id="address-input" name="address_address" class="form-control map-input"> --}}
                    <input type="hidden" id="address-input" name="address_address" class="form-control map-input">
                    <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                    <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                </div>
            </form>
            <div id="address-map-container" style="width:100%;height:480px; ">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div>
        </div>
        <div class="col-md-5 col-sm-5">
            <h4>Addess and Business hours</h4>
            @foreach ($locations as $location)
            <div>
                <h5>Address</h5>
                <h6>{{ $location->address }}</h6>
                <h6>{{ $location->surburb }} , {{ $location->city }}</h6>
            </div>
            <div class="mt-5">
                <h5>Business Houre</h5>
                <h6>Weekday: {{ $location->weekday_hours }}</h6>
                <h6>Weekend,Public Holiday: {{ $location->weekend_hours }}</h6>
            </div>
            <div class="mt-5">
                <h5>Phone Number</h5>
                <h6>Customer Center: {{ $location->phone_number }}</h6>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=places&callback=initialize" async defer></script>
<script src="/js/mapInput.js"></script>
@endsection
