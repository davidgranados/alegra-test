<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

/** @see \App\Models\MarketPurchase */
class MarketPurchaseCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $response = parent::toArray($request);
        $response = array_map(function ($purchase) {
            return [
                'id' => $purchase['id'],
                'order_id' => $purchase['order_id'],
                'ingredient' => $purchase['ingredient']['name'],
                'quantity' => $purchase['quantity']
            ];
        }, $response);
        return [
            'data' => $response,
        ];
    }
}
