<?php
namespace Tests\Feature\Http;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class HotelSearchTest extends TestCase
{
    public function test_endpoint_returns_json()
    {
        Http::fake(['*' => Http::response([
            ['hotel'=>'C1','loc'=>'L','rate'=>100,'roomsLeft'=>2,'score'=>4.0]
        ], 200)]);

        $response = $this->getJson('/api/hotels/search?location=L&check_in=2025-09-01&check_out=2025-09-02');
        $response->assertStatus(200)
                 ->assertJsonStructure([ ['name','location','price_per_night','available_rooms','rating','source'] ]);
    }
}
