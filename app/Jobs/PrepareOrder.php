<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Stock;
use App\Models\StockReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        dump($this->order->recipe->name);
        dump($this->order->recipe->id);
        $needToBuy = [];
        foreach ($this->order->recipe->ingredients as $ingredient) {
            $stock = $ingredient->stock;
            $order = $this->order;

            $stockNeeded = $ingredient->pivot->quantity;
            $stockReserved =
                $order->reservations->where('stock_id', $stock->id)->first();

            if ($stockReserved) {
                $stockNeeded -= $stockReserved->quantity;
            }
            if ($stockNeeded > $stock->quantity) {
                if ($stock->quantity) {
                    $stockForReserve = $stock->quantity;
                    $stock->quantity -= $stockForReserve;
                    $stock->save();
                    $stockReservation = StockReservation::create([
                        'order_id' => $order->id,
                        'stock_id' => $stock->id,
                        'quantity' => $stockForReserve
                    ]);
                    $stockReservations[] = $stockReservation->toArray();
                    $stockToBuy = $stockNeeded - $stockReservation->quantity;
                } else {
                    $stockToBuy = $stockNeeded;
                }
                $needToBuy[$ingredient->name] = $stockToBuy;
            }
        }
        dump($needToBuy);

//        sleep(10);
//        $this->order->markAsReady();
    }
}
