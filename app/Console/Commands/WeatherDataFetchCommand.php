<?php

namespace App\Console\Commands;

use App\Models\Weather;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WeatherDataFetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab weather data for a given list of longitudes and latitudes scheduled every 2 minutes.';

    /**
     * @var array
     */
    protected $cities = [
        'Berlin Mitte' => ['lat' => 52.520008, 'lon' => 13.404954],
        'Berlin Friedrichshain' => ['lat' => 52.515816, 'lon' => 13.454293],
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Fetching weather data...');

        foreach ($this->cities as $city => $coordinates) {
            $response = Http::get('api.openweathermap.org/data/2.5/weather', [
                'units' => 'metric',
                'lat' => $coordinates['lat'],
                'lon' => $coordinates['lon'],
                'appid' => 'bf65d8b174418831a16055a19f50144f'
            ])->json();

            Weather::create([
                'time' => now(),
                'name' => $response['name'],
                'latitude' => $response['coord']['lat'],
                'longitude' => $response['coord']['lon'],
                'temp_celcius' => $response['main']['temp'],
                'pressure' => $response['main']['pressure'],
                'humidity' => $response['main']['humidity'],
                'temp_min' => $response['main']['temp_min'],
                'temp_max' => $response['main']['temp_max'],
            ]);
        }

        $this->info('Done.');

        return 0;
    }
}
