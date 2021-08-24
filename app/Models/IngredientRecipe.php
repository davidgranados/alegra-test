<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\IngredientRecipe
 *
 * @property int $id
 * @property int $recipe_id
 * @property int $ingredient_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientRecipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientRecipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientRecipe query()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientRecipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientRecipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientRecipe whereIngredientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientRecipe whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientRecipe whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientRecipe whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IngredientRecipe extends Pivot
{
    //
}
