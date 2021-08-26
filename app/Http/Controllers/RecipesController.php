<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeCollection;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipesController extends Controller
{

    public function index()
    {
        $query = Recipe::with('ingredients');
        return \response(
            new RecipeCollection($query->get()),
            Response::HTTP_OK
        );
    }
}
