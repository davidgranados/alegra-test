<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

/** @see \App\Models\Recipe */
class RecipeCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $response = parent::toArray($request);
        $newResponse = [];
        foreach ($response as $recipe) {
            $ingredients = [];
            foreach ($recipe['ingredients'] as $ingredient) {
                $ingredients[$ingredient['name']] = $ingredient['pivot']['quantity'];
            }
            $newResponse[$recipe['name']] = $ingredients;
        }
        return [
            'data' => $newResponse,
        ];
    }
}
