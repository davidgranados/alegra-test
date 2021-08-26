<?php

namespace App\Jobs;

use App\Models\Ingredient;
use App\Models\MarketPurchase;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 *
 */
class BuyIngredients implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $needToBuy;
    private Order $order;

    /**
     * @param Order $order
     * @param array $needToBuy
     *  Format: [string ingredientName => int quantity]
     *  example: ['tomato' => 1, 'chicken' => 2]
     */
    public function __construct(Order $order, array $needToBuy)
    {
        $this->needToBuy = $needToBuy;
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
        foreach ($this->needToBuy as $ingredientName => $quantity) {
            DB::transaction(
                function () use ($ingredientName, $order, $quantity) {
                    $stockBought = 0;
                    $ingredient =
                        Ingredient::with('stock')->where(
                            'name',
                            $ingredientName
                        )
                            ->first();
                    do {
                        $response = Http::get(
                            "https://recruitment.alegra.com/api/farmers-market/buy?ingredient={$ingredientName}"
                        );
                        if ($response['quantitySold']) {
                            $stockBought += (int)$response['quantitySold'];
                            MarketPurchase::create([
                                'ingredient_id' => $ingredient->id,
                                'order_id' => $order->id,
                                'quantity' => $response['quantitySold']
                            ]);
                        }
                    } while ($quantity >= $stockBought);
                    $newStock = $ingredient->stock->quantity + $stockBought;
                    $ingredient->stock->update(['quantity' => $newStock]);
                }
            );
        }
        PrepareOrder::dispatch($order);
    }
}
