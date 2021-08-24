<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = Ingredient::all();
        foreach ($ingredients as $ingredient) {
            Stock::create(
                [
                    'ingredient_id' => $ingredient->id,
                    'quantity' => 5
                ]
            );
        }
    }
}
