<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MarketPurchase
 *
 * @property int $id
 * @property int $ingredient_id
 * @property int $order_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ingredient $ingredient
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|MarketPurchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketPurchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketPurchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketPurchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketPurchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketPurchase whereIngredientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketPurchase whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketPurchase whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketPurchase whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
