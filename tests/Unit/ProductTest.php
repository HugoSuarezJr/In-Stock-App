<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_stock_for_products_at_retailers()
    {
        $this->seed(RetailerWithProductSeeder::class);

        tap(Product::first(), function ($product) {
            $this->assertFalse($product->inStock());

            $product->stock()->first()->update(['in_stock' => true]);

            dd($product->stock()->first());

            $this->assertTrue($product->inStock());
        });
    }
}
