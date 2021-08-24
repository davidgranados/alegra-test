<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class OrdersController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $query = Order::query()->where('status', $status);
        return \response(
            new OrderCollection($query->get()),
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quantity = (int) $request->get('quantity', 1);
        $recipes = Recipe::all();
        $createdOrders = [];
        foreach (range(1, $quantity) as $_) {
            $createdOrders[] =
                Order::create(['recipe_id' => $recipes->random()->id]);
        }
        return \response(
            new OrderCollection($createdOrders),
            Response::HTTP_CREATED
        );
    }
}
