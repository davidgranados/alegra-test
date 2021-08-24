<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = [
            'tomato',
            'lemon',
            'potato',
            'rice',
            'ketchup',
            'lettuce',
            'onion',
            'cheese',
            'meat',
            'chicken',
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create(['name' => $ingredient]);
        }
    }
}
