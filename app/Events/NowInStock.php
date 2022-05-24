<?php

namespace App\Events;

use App\Models\Stock;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NowInStock
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var \App\Models\Stock
     */

     public Stock $stock;
    /**
     * Create a new event instance.
     *
     * @param \App\Models\Stock $stock
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
