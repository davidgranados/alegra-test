<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeCollection;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class RecipesController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        $query = Recipe::with('ingredients');
        return \response(
            new RecipeCollection($query->get()),
            Response::HTTP_OK
        );
    }
}
