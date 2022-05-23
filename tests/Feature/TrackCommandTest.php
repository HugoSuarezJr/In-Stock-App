<?php

namespace Tests\Feature;

use App\Clients\StockStatus;
use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use App\Models\User;
use Database\Seeders\RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_tracks_product_stock()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $this->assertFalse(Product::first()->inStock());

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available = true, $price = 29900));

        $this->artisan('track')
            ->expectsOutput("All done!");

        $this->assertTrue(Product::first()->inStock());
    }

    /** @test */
    function it_notifies_the_user_when_the_stock_changes_in_a_notable_way()
    {
        Notification::fake();
        // Given I have a user
        $user = User::factory()->create(['email' => 'HugoSuarez@example.com']);
        // And a product
        $this->seed(RetailerWithProductSeeder::class);

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available = true, $price = 29900));
        // When I track that product
        $this->artisan('track');
        // If the stock changes in a notable way after being tracked

        // Then the user should be notified.\

        Notification::assertSentTo($user, ImportantStockUpdate::class);
    }
}
