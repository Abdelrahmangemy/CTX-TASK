<?php
namespace App\DTOs;

class HotelDto
{
    public string $name;
    public string $location;
    public float $pricePerNight;
    public int $availableRooms;
    public float $rating;
    public string $source;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->location = $data['location'];
        $this->pricePerNight = $data['price_per_night'];
        $this->availableRooms = $data['available_rooms'];
        $this->rating = $data['rating'];
        $this->source = $data['source'];
    }
}
