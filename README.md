# Multi-Supplier Hotel Search API

This Laravel-based API enables searching for hotels across multiple suppliers, merging and normalizing results, and applying dynamic filters such as price range, guest count, and sorting (by price or rating).

---

## Features

- Parallel fetching from 4 hotel suppliers (mocked APIs)
- Merging results while removing duplicates
- Selecting best price for duplicate hotels
- Filtering by:
  - Location
  - Date range
  - Guest count
  - Price range
- Sorting by:
  - Price
  - Rating
- Logging failed supplier requests
- Fully tested (unit + feature tests)
---

## ⚙️ Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/hotel-search-api.git
cd hotel-search-api
```
### 2. Install Dependencies

```bash
composer install
```

### 3. Create Environment File

```bash
cp .env.example .env
php artisan key:generate
```

No DB configuration is required unless you'd like to extend it.

### 4. Serve the Application

```bash
php artisan serve
```
## API Usage

### Endpoint

```
GET /api/hotels/search
```
### Example Request

```http
GET /api/hotels/search?location=Cairo&check_in=2025-08-10&check_out=2025-08-12&guests=2&min_price=50&max_price=200&sort_by=price
```

### Example Response

```json
[
  {
    "name": "Hotel Example",
    "location": "Cairo, Egypt",
    "price_per_night": 120,
    "available_rooms": 5,
    "rating": 4.5,
    "source": "supplier_a"
  }
]
```

---
## Code Structure

```
app/
├── Contracts/
│   └── HotelSupplierInterface.php
├── DTOs/
│   └── HotelDto.php
├── Exceptions/
│   └── SupplierException.php
├── Http/
│   ├── Controllers/
│   │   └── HotelSearchController.php
│   ├── Requests/
│   │   └── HotelSearchRequest.php
│   └── Resources/
│       └── HotelResource.php
├── Services/
│   ├── HotelSearchService.php
│   └── Suppliers/
│       ├── SupplierAAdapter.php
│       ├── SupplierBAdapter.php
│       ├── SupplierCAdapter.php
│       └── SupplierDAdapter.php
routes/
└── api.php
tests/
├── Feature/
│   └── Http/HotelSearchTest.php
└── Unit/
    └── Services/HotelSearchServiceTest.php
```

---

## Design Decisions

### Parallelism

- Uses `GuzzleHttp\Promise\Utils::task()` and `settle()` for concurrent fetches.

### Merging Strategy
- Deduplication by hotel `name + location`, lowest price wins.

### Fault Tolerance

- Failed supplier requests are logged and ignored.

### Filtering

- Filters by guest count and price range.

### Sorting

- Supports sorting by `price` or `rating`.

---

## Running Tests

```bash
php artisan test
```
### Includes:

- Merging logic
- Filtering by price and guests
- Sorting
- Supplier failure handling
- API response structure

---

## Future Improvements

- Caching (Redis or file-based)
- Real HTTP integration for suppliers
- Pagination support
- Stronger validation via DTOs

---
