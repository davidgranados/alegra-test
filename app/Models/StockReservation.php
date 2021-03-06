<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StockReserved
 *
 * @property int                             $id
 * @property int                             $stock_id
 * @property int                             $order_id
 * @property int                             $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order          $order
 * @property-read \App\Models\Stock          $stock
 * @method static \Illuminate\Database\Eloquent\Builder|StockReservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockReservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockReservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockReservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockReservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockReservation whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockReservation whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockReservation whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockReservation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StockReservation extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['order_id', 'stock_id', 'quantity'];

    protected static function booted()
    {
        parent::booted(); // TODO: Change the autogenerated stub
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
