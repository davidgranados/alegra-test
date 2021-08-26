<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPurchase extends Model
{
    protected $fillable = ['ingredient_id', 'order_id', 'quantity'];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
