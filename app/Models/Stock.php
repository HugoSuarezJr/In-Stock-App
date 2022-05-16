<?php

namespace App\Models;


use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track()
    {
        $class = "App\\Clients\\" . Str::studly($this->retailer->name);

        $status = (new $class)->checkAvailability($this);

        // if ($this->retailer->name === 'Best Buy') {
        //     $status = (new BestBuy())->checkAvailability($this);
        // }
        // if ($this->retailer->name === 'Target') {
        //     $status = (new Target())->checkAvailability($this);
        // }

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

