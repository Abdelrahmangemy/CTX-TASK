<?php
namespace App\Services\Suppliers;

use App\Contracts\HotelSupplierInterface;
use App\DTOs\HotelDto;

class SupplierDAdapter implements HotelSupplierInterface
{
    public function fetch(array $criteria): array
    {
        return [ ['title'=>'D1','place'=>'Cairo, Egypt','cost'=>95,'roomsAvail'=>3,'stars'=>4.1] ];
    }
    public function normalize(array $raw): array
    {
        return array_map(fn($i) => new HotelDto([
            'name'=>$i['title'],
            'location'=>$i['place'],
            'price_per_night'=>$i['cost'],
            'available_rooms'=>$i['roomsAvail'],
            'rating'=>$i['stars'],
            'source'=>'supplier_d'
        ]), $raw);
    }
}
