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
        // 0,tomato
        // 1,lemon
        // 2,potato
        // 3,rice
        // 4,ketchup
        // 5,lettuce
        // 6,onion
        // 7,cheese
        // 8,meat
        // 9,chicken
        $ingredients = Ingredient::all();

        // 1,vue salad
        $recipe = Recipe::find(1);
        $recipe->ingredients()->attach($ingredients[1], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[2], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[3], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[4], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[5], ['quantity' => 3]);
        $recipe->ingredients()->attach($ingredients[6], ['quantity' => 3]);
        $recipe->ingredients()->attach($ingredients[7], ['quantity' => 1]);
        // 2,react salad
        $recipe = Recipe::find(2);
        $recipe->ingredients()->attach($ingredients[8], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[9], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[0], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[1], ['quantity' => 3]);
        // 3,angular salad
        $recipe = Recipe::find(3);
        $recipe->ingredients()->attach($ingredients[2], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[3], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[4], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[5], ['quantity' => 3]);
        // 4,php chicken
        $recipe = Recipe::find(4);
        $recipe->ingredients()->attach($ingredients[6], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[7], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[8], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[9], ['quantity' => 3]);
        $recipe->ingredients()->attach($ingredients[0], ['quantity' => 1]);
        // 5,python beef
        $recipe = Recipe::find(5);
        $recipe->ingredients()->attach($ingredients[1], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[2], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[3], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[4], ['quantity' => 3]);
        $recipe->ingredients()->attach($ingredients[5], ['quantity' => 1]);
        // 6,node fish
        $recipe = Recipe::find(5);
        $recipe->ingredients()->attach($ingredients[6], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[7], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[8], ['quantity' => 2]);
    }
}
