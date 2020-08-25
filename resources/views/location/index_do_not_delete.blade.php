@extends('layouts.app')

@section('title')
{{ config('app.name') }} - Shop Location
@endsection

@section('content')

<div class="container mt-5">
    {{-- <get-location></get-location><!-- cannot use like this vue... --> --}}
    <div class="row">
        <div class="col-md-8 col-sm-8">
            <h2>Shop Location</h2>
            <div class="map">
                <!-- map with my shop goes here -->
                <gmap-map
                    :center="mapCenter"
                    :zoom="10"
                    style="width: 100%; height: 440px;"><!-- @click="handleMapClick" -->
                    <gmap-info-window
                        :options="infoWindowOptions"
                        :position="infoWindowPosition"
                        :opened="infoWindowOpened"
                        @closeclick="handleInfoWindowClose">
                        <div class="info-window">
                            <h2 v-text="activeLocation.name"></h2>
                            <h5 v-text="'Weekday: ' + activeLocation.weekday_hours"></h5>
                            <h5 v-text="'Weekend,Public Holiday: ' + activeLocation.weekend_hours"></h5>
                            <h5 v-text="activeLocation.address"></h5>
                            <h5 v-text="activeLocation.surburb + ', ' + activeLocation.city"></h5>
                        </div>
                    </gmap-info-window>
                    <gmap-marker v-for="(location, index) in locations"
                        :key="location.id"
                        :position="getPosition(location)"
                        :clickable="true"
                        :draggable="false"
                        @click="handleMarkerClicked(location)">
                    </gmap-marker>
                </gmap-map>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            @foreach ($locations as $location)
            <div>
                <h2>Address</h2>
                <h5>{{ $location->address }}</h5>
                <h5>{{ $location->surburb }} , {{ $location->city }}</h5>
            </div>
            <div class="mt-5">
                <h2>Business Houre</h2>
                <h5>Weekday: {{ $location->weekday_hours }}</h5>
                <h5>Weekend,Public Holiday: {{ $location->weekend_hours }}</h5>
            </div>
            <div class="mt-5">
                <h2>Phone Number</h2>
                <h5>Customer Center: {{ $location->phone_number }}</h5>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('extra-js')

@endsection
