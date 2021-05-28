<?php

namespace App\Http\Controllers;

use App\Http\Resources\WeatherResource;
use App\Models\Weather;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = Weather::when($request->name, function ($query) use ($request) {
            $query->where('name', $request->name);
        })->get();

        return WeatherResource::collection($data);
    }
}
