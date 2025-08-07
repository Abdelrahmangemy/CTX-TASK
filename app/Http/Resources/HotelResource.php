<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($hotel): array
    {
        return [
            'name' => $hotel->name,
            'location' => $hotel->location,
            'price_per_night' => $hotel->pricePerNight,
            'available_rooms' => $hotel->availableRooms,
            'rating' => $hotel->rating,
            'source' => $hotel->source,
        ];
    }
}
