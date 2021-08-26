<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\StockReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class PrepareOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Order $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;
        $needToBuy = [];
        $stocksToPrepare = [];
        foreach ($this->order->recipe->ingredients as $ingredient) {
            $stock = $ingredient->stock;

            $stockNeeded = $ingredient->pivot->quantity;
            $stockReserved =
                $order->reservations->where('stock_id', $stock->id)->first();

            if ($stockReserved) {
                $stockNeeded -= $stockReserved->quantity;
            }
            if ($stockNeeded > $stock->quantity) {
                if ($stock->quantity) {
                    $stockReservation = null;
                    DB::transaction(
                        function () use ($stock, $order, &$stockReservation) {
                            $stockForReserve = $stock->quantity;
                            $stock->quantity -= $stockForReserve;
                            $stock->save();
                            $stockReservation = StockReservation::create([
                                'order_id' => $order->id,
                                'stock_id' => $stock->id,
                                'quantity' => $stockForReserve
                            ]);
                        }
                    );
                    $stockReservations[] =
                        $stockReservation ?? $stockReservation->toArray();
                    $stockToBuy = $stockNeeded - $stockReservation->quantity;
                } else {
                    $stockToBuy = $stockNeeded;
                }
                $needToBuy[$ingredient->name] = $stockToBuy;
            } else {
                $stocksToPrepare[] = [
                    'ingredient' => $ingredient,
                    'stockNeeded' => $stockNeeded
                ];
            }
        }
        if ($needToBuy) {
            BuyIngredients::dispatch($order, $needToBuy);
            foreach ($stocksToPrepare as $stockToPrepare) {
                DB::transaction(
                    function () use ($order, $stockToPrepare) {
                        $stock = $stockToPrepare['ingredient']->stock;
                        $stock->quantity -= $stockToPrepare['stockNeeded'];
                        $stock->save();
                        StockReservation::create([
                            'order_id' => $order->id,
                            'stock_id' => $stock->id,
                            'quantity' => $stockToPrepare['stockNeeded']
                        ]);
                    }
                );
            }
        } else {
            DB::transaction(
                function () use ($order, $stocksToPrepare) {
                    foreach ($stocksToPrepare as $stockToPrepare) {
                        $stock = $stockToPrepare['ingredient']->stock;
                        $stock->quantity -= $stockToPrepare['stockNeeded'];
                        $stock->save();
                    }
                    $order->status = Order::READY_STATUS;
                    $order->save();
                    $order->reservations()->delete();
                }
            );
        }
    }
}
