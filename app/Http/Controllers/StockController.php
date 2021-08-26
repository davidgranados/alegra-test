<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockCollection;
use App\Models\Stock;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Stock::with('ingredient');
        return \response(
            new StockCollection($query->get()),
            Response::HTTP_OK
        );
    }
}
