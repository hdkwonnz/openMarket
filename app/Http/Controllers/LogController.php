<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

// https://dzone.com/articles/5-minute-solution-for-viewing-logs-in-a-laravel-ap

class LogController extends Controller
{
    public function show(Request $request)
    {
        //return $request->all();

        $selectedDate = new Carbon($request->get('selectedDate',today()));

        $filePath = storage_path("logs/laravel-{$selectedDate->format('Y-m-d')}.log");

        ////for one log file
        // $filePath = storage_path("logs/laravel.log");

        $data = [];

        if (File::exists($filePath)){
            $data = [
                'lastModified' => new Carbon(File::lastModified($filePath)),
                'size' => File::size($filePath),
                'file' => File::get($filePath),
            ];
        }

        //return $data;
        return view('logs.logs', compact('selectedDate','data'));
    }
}
