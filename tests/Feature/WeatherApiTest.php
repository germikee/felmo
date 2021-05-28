<?php

namespace Tests\Feature;

use App\Models\Weather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_get_list_of_weather_data()
    {
        Weather::factory(5)->create();

        $this->json('GET', route('weather.index'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'time',
                        'name',
                        'latitude',
                        'longitude',
                        'temp_celcius',
                        'pressure',
                        'humidity',
                        'temp_min',
                        'temp_max',
                    ]
                ]
            ])
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_should_filter_weather_data_by_name()
    {
        Weather::factory(5)->create();
        Weather::factory()->create([
            'name' => 'Test',
        ]);

        $this->json('GET', route('weather.index', ['name' => 'test']))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'time',
                        'name',
                        'latitude',
                        'longitude',
                        'temp_celcius',
                        'pressure',
                        'humidity',
                        'temp_min',
                        'temp_max',
                    ]
                ]
            ]);
    }
}
