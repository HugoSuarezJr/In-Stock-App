<?php

namespace App\Models;

use App\Clients\BestBuy;
use App\Clients\Target;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track()
    {
        if ($this->retailer->name === 'Best Buy') {
            $status = (new BestBuy())->checkAvailability($this);
        }
        if ($this->retailer->name === 'Target') {
            $status = (new Target())->checkAvailability($this);
        }

        $this->update([
            'in_stock' => $status->available,
            'price' => $status->price
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}

