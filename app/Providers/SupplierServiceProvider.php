<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Suppliers\{
    SupplierAAdapter,
    SupplierBAdapter,
    SupplierCAdapter,
    SupplierDAdapter
};

class SupplierServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('supplier_a', SupplierAAdapter::class);
        $this->app->singleton('supplier_b', SupplierBAdapter::class);
        $this->app->singleton('supplier_c', SupplierCAdapter::class);
        $this->app->singleton('supplier_d', SupplierDAdapter::class);
    }
}
