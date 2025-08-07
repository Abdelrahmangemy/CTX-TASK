<?php
namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\HotelSearchService;
use App\Contracts\HotelSupplierInterface;
use App\DTOs\HotelDto;

class HotelSearchServiceTest extends TestCase
{
    public function test_merging_and_filtering()
    {
        $supplier = $this->createMock(HotelSupplierInterface::class);
        $supplier->method('fetch')->willReturn([
            ['name'=>'X','location'=>'Loc','price_per_night'=>100,'available_rooms'=>2,'rating'=>4.0,'source'=>'x']
        ]);
        $supplier->method('normalize')->willReturn([
            new HotelDto(['name'=>'X','location'=>'Loc','price_per_night'=>100,'available_rooms'=>2,'rating'=>4.0,'source'=>'x'])
        ]);

        $service = new HotelSearchService([$supplier]);
        $results = $service->search(['min_price'=>50,'max_price'=>150,'guests'=>1]);

        $this->assertCount(1, $results);
        $this->assertEquals(100, $results[0]->pricePerNight);
    }

    public function test_exception_does_not_break()
    {
        $supplier = $this->createMock(HotelSupplierInterface::class);
        $supplier->method('fetch')->willThrowException(new \Exception('fail'));
        $supplier->method('normalize')->willReturn([]);

        $service = new HotelSearchService([$supplier]);
        $results = $service->search([]);

        $this->assertEmpty($results);
    }

    public function test_sorting_by_price()
    {
        $low = new HotelDto(['name'=>'A','location'=>'L','price_per_night'=>80,'available_rooms'=>1,'rating'=>4.0,'source'=>'s']);
        $high = new HotelDto(['name'=>'B','location'=>'L','price_per_night'=>120,'available_rooms'=>1,'rating'=>4.5,'source'=>'s']);
        $supplier = $this->createMock(HotelSupplierInterface::class);
        $supplier->method('fetch')->willReturn([]);
        $supplier->method('normalize')->willReturn([
            $high, $low
        ]);

        $service = new HotelSearchService([$supplier]);
        $results = $service->search(['sort_by'=>'price']);

        $this->assertEquals(80, $results[0]->pricePerNight);
        $this->assertEquals(120, $results[1]->pricePerNight);
    }

    public function test_duplicate_hotels_returns_lowest_price()
    {
        $dto1 = new HotelDto(['name'=>'Same','location'=>'L','price_per_night'=>200,'available_rooms'=>2,'rating'=>5.0,'source'=>'a']);
        $dto2 = new HotelDto(['name'=>'Same','location'=>'L','price_per_night'=>150,'available_rooms'=>2,'rating'=>4.8,'source'=>'b']);
        $supplierA = $this->createMock(HotelSupplierInterface::class);
        $supplierA->method('fetch')->willReturn([]);
        $supplierA->method('normalize')->willReturn([
            $dto1
        ]);
        $supplierB = $this->createMock(HotelSupplierInterface::class);
        $supplierB->method('fetch')->willReturn([]);
        $supplierB->method('normalize')->willReturn([
            $dto2
        ]);

        $service = new HotelSearchService([$supplierA, $supplierB]);
        $results = $service->search([]);

        $this->assertCount(1, $results);
        $this->assertEquals(150, $results[0]->pricePerNight);
    }
}
