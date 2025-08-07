<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelSearchRequest;
use App\Http\Resources\HotelResource;
use App\Services\HotelSearchService;

class HotelSearchController extends Controller
{
    public function __invoke(HotelSearchRequest $request, HotelSearchService $service)
    {
        $results = $service->search($request->validated());
        return HotelResource::collection($results);
    }
}
