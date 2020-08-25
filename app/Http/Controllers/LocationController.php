<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Cache::store('redis')->remember('location.index', now()->addHours(24), function() {
            return (Location::all());
        });

        // return $locations;
        return view ('location.index',compact('locations'));
    }

    public function getLocations()
    {
        $locations = Cache::store('redis')->remember('location.index', now()->addHours(24), function() {
            return (Location::all());
        });

        //return $locations;

        return response()->json([
            'locations' => $locations,
        ]);
    }
}
