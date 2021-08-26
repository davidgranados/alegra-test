<?php

namespace App\Http\Controllers;

use App\Http\Resources\MarketPurchaseCollection;
use App\Models\MarketPurchase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarketPurchasesController extends Controller
{
    public function index()
    {
        $query = MarketPurchase::with('ingredient');
        return \response(
            new MarketPurchaseCollection($query->get()),
            Response::HTTP_OK
        );
    }
}
