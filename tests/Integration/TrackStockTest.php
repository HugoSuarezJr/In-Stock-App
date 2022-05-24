<?php

namespace Tests\Integration;

use App\Models\History;
use App\Models\Product;
use App\Models\Stock;
use App\Notifications\ImportantStockUpdate;
use App\UseCases\TrackStock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackStockTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp():void
    {
        parent::setUp();

        Notification::fake();

        $this->mockClientRequest($available = true, $price = 69900);

        $this->seed(RetailerWithProductSeeder::class);

        (new TrackStock(Stock::first()))->handle();
    }

    /** @test */
    function it_notifies_the_user()
    {
        Notification::assertTimesSent(1, ImportantStockUpdate::class);
    }

    /** @test */
    function it_refreshes_the_local_stock()
    {
        tap(Stock::first(), function ($stock){
            $this->assertEquals(69900, $stock->price);
            $this->assertTrue($stock->in_stock);
        });
    }

    /** @test */
    function it_records_to_history()
    {
        $this->assertEquals(1, History::count());
    }
}
