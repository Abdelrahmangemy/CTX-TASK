<?php
namespace App\Services\Suppliers;

use App\Contracts\HotelSupplierInterface;
use App\DTOs\HotelDto;

class SupplierCAdapter implements HotelSupplierInterface
{
    public function fetch(array $criteria): array
    {
        return [ ['hotel'=>'C1','loc'=>'Cairo, Egypt','rate'=>110,'roomsLeft'=>5,'score'=>4.3] ];
    }
    public function normalize(array $raw): array
    {
        return array_map(fn($item) => new HotelDto([
            'name'=>$item['hotel'],
            'location'=>$item['loc'],
            'price_per_night'=>$item['rate'],
            'available_rooms'=>$item['roomsLeft'],
            'rating'=>$item['score'],
            'source'=>'supplier_c'
        ]), $raw);
    }
}
