<?php
namespace App\Services\Suppliers;

use App\Contracts\HotelSupplierInterface;
use App\DTOs\HotelDto;

class SupplierBAdapter implements HotelSupplierInterface
{
    public function fetch(array $criteria): array
    {
        // simulate
        return [
          ['name'=>'B1', 'location'=>'Cairo, Egypt', 'price'=>90, 'available'=>2, 'rating'=>3.8],
        ];
    }

    public function normalize(array $raw): array
    {
        return array_map(fn($i) => new HotelDto([
            'name'=>$i['name'],
            'location'=>$i['location'],
            'price_per_night'=>$i['price'],
            'available_rooms'=>$i['available'],
            'rating'=>$i['rating'],
            'source'=>'supplier_b'
        ]), $raw);
    }
}
