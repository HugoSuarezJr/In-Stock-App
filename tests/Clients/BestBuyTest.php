<?php

namespace Tests\Clients;

use App\Clients\BestBuy;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

/**
 * @group api
 */

class BestBuyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_a_product()
    {
        $this->seed(RetailerWithProductSeeder::class);

       $stock = tap(Stock::first())->update([
            'sku' => '6407742', // DJI Mavic Air 2
            'url' => 'https://www.bestbuy.com/site/dji-mavic-air-2-drone-fly-more-combo-with-remote-controller-black/6407742.p?skuId=6407742'
        ]);

        try {
            (new BestBuy())->checkAvailability($stock);
        } catch (\Exception $e) {
            $this->fail('Failed to track the BestBuy API properly.');
        }
        assertTrue(true);
    }
}
