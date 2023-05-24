<?php

namespace Tests\Feature\v3;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeatherApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_cities()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/v3/cities');

        $response->assertOk();
        $response->assertJson([
            'status' => 'success',
            'messages' => [],
        ]);
    }

    public function test_city_weather_by_city_id_not_found()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/v3/cities/text');

        $response->assertNotFound();
        $response->assertJson([
            'status' => 'error',
            'message' => 'The city with id=text not found',
        ]);
    }

    public function test_city_weather_udpate()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/v3/cities/update/moscow');

        $response->assertOk();
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function test_city_weather_udpate_wrong_city_name()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/v3/cities/update/moscowwwww');

        $response->assertStatus(500);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Something went wrong. Make sure you send the correct name for the city',
        ]);
    }
}
