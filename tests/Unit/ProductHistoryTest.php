<?php

namespace Tests\Unit;

use App\Models\History;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\Stock;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_each_time_stock_is_tracked()
    {
        // given I have stock at a retailer
        $this->seed(RetailerWithProductSeeder::class);

        Http::fake(fn() => ['salePrice' => 99, 'onlineAvailability' => true]);

        $this->assertEquals(0, History::count());
        // if I track that stock
        $stock = tap(Stock::first())->track();

        // a new history entry should be created
        $this->assertEquals(1, History::count());

        $history = History::first();

        $this->assertEquals($stock->price, $history->price);
        $this->assertEquals($stock->in_stock, $history->in_stock);
        $this->assertEquals($stock->product_id, $history->product_id);
        $this->assertEquals($stock->id, $history->stock_id);
    }
}
