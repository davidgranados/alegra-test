<?php

namespace App\Http\Controllers;

use App\Http\Resources\MarketPurchaseCollection;
use App\Models\MarketPurchase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class MarketPurchasesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        $query = MarketPurchase::with('ingredient');
        return \response(
            new MarketPurchaseCollection($query->get()),
            Response::HTTP_OK
        );
    }
}
