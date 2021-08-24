<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientRecipe;
use App\Models\Recipe;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;

class IngredientRecipeSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipes = Recipe::all();

        foreach ($recipes as $recipe) {
            $maxIngredientsQty = $this->faker->numberBetween(5, 10);
            foreach (range(0, $maxIngredientsQty) as $number) {
                $recipeIngredientQty = $this->faker->numberBetween(1, 3);
                $ingredient = Ingredient::inRandomOrder()->first();
                IngredientRecipe::firstOrCreate(
                    [
                        'recipe_id' => $recipe->id,
                        'ingredient_id' => $ingredient->id
                    ],
                    [
                        'quantity' => $recipeIngredientQty
                    ]
                );
            }
        }
    }
}
