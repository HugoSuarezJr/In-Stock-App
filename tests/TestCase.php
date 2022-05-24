<?php

namespace Tests;

use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory as ClientsClientFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function mockClientRequest($available = true, $price = 29900)
    {
        ClientsClientFactory::shouldReceive('make->checkAvailability')
        ->andReturn(new StockStatus($available, $price));
    }
}
