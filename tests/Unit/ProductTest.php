<?php

namespace Tests\Feature;

use App\Models\Product;
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

            $this->assertTrue($product->inStock());
        });

        // $switch = Product::create(['name' => 'Nintedno Switch']);

        // $bestBuy = Retailer::create(['name' => ' Best Buy']);

        // $this->assertFalse($switch->inStock());

        // $stock = new Stock([
        //     'price' => 10000,
        //     'url' => 'http://foo.com',
        //     'sku' => 12345,
        //     'in_stock' => true
        // ]);

        // $bestBuy->addStock($switch, $stock);

        // $this->assertTrue($switch->inStock());
    }
}
