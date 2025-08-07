<?php
namespace App\Contracts;

use App\DTOs\HotelDto;

interface HotelSupplierInterface
{
    /**
     * Fetch raw supplier data.
     *
     * @param array $criteria
     * @return array
     * @throws \App\Exceptions\SupplierException
     */
    public function fetch(array $criteria): array;

    /**
     * Normalize raw data to DTOs.
     *
     * @param array $raw
     * @return HotelDto[]
     */
    public function normalize(array $raw): array;
}
