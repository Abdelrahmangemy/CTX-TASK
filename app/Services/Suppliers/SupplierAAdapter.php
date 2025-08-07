<?php
namespace App\Services\Suppliers;

use App\Contracts\HotelSupplierInterface;
use App\DTOs\HotelDto;
use App\Exceptions\SupplierException;
use GuzzleHttp\Client;

class SupplierAAdapter implements HotelSupplierInterface
{
    public function fetch(array $criteria): array
    {
        // Mocked HTTP request
        // $response = (new Client())->get('https://api.supplier-a.com/hotels', ['query' => $criteria]);
        // return json_decode($response->getBody(), true);
        return [
          ['hotel_name'=>'A1', 'city'=>'Cairo, Egypt', 'nightly_rate'=>100, 'rooms'=>4, 'stars'=>4.0],
          // ...
        ];
    }

    public function normalize(array $raw): array
    {
        return array_map(fn($item) => new HotelDto([
            'name' => $item['hotel_name'],
            'location' => $item['city'],
            'price_per_night' => $item['nightly_rate'],
            'available_rooms' => $item['rooms'],
            'rating' => $item['stars'],
            'source' => 'supplier_a'
        ]), $raw);
    }
}
