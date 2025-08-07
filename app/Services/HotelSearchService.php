<?php
namespace App\Services;

use App\Contracts\HotelSupplierInterface;
use App\DTOs\HotelDto;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Promise;

class HotelSearchService
{
    private array $suppliers;

    public function __construct(array $suppliers)
    {
        $this->suppliers = $suppliers;
    }

    /**
     * Perform parallel fetch, normalize, merge, filter & sort.
     */
    public function search(array $criteria): array
    {
        $promises = [];
        foreach ($this->suppliers as $key => $supplier) {
            $promises[$key] = Promise\Utils::task(fn() => $this->safeFetch($supplier, $criteria));
        }

        $results = Promise\Utils::settle($promises)->wait();
        $dtos = array_reduce($results, function($carry, $item) {
            return $carry + ($item['value'] ?? []);
        }, []);

        // Merge duplicates, keep lowest price
        $merged = [];
        foreach ($dtos as $hotel) {
            $key = strtolower($hotel->name . '|' . $hotel->location);
            if (!isset($merged[$key]) || $hotel->pricePerNight < $merged[$key]->pricePerNight) {
                $merged[$key] = $hotel;
            }
        }

        // Apply filters (price range, guests)
        $filtered = array_values(array_filter($merged, fn(HotelDto $h) => $this->applyFilters($h, $criteria)));

        // Sort
        if (!empty($criteria['sort_by'])) {
            usort($filtered, fn($a, $b) => $b->{$criteria['sort_by']} <=> $a->{$criteria['sort_by']});
        }

        return $filtered;
    }

    private function safeFetch(HotelSupplierInterface $supplier, array $criteria): array
    {
        try {
            $raw = $supplier->fetch($criteria);
            return $supplier->normalize($raw);
        } catch (\Throwable $e) {
            Log::error('Supplier failed: '. $supplier::class . ' — ' . $e->getMessage());
            return [];
        }
    }

    private function applyFilters(HotelDto $h, array $criteria): bool
    {
        if (isset($criteria['min_price']) && $h->pricePerNight < $criteria['min_price']) {
            return false;
        }
        if (isset($criteria['max_price']) && $h->pricePerNight > $criteria['max_price']) {
            return false;
        }
        if (isset($criteria['guests']) && $h->availableRooms < $criteria['guests']) {
            return false;
        }
        return true;
    }
}
