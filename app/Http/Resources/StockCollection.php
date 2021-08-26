<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Stock */
class StockCollection extends ResourceCollection
{

    public function toArray($request)
    {
        $response = parent::toArray($request);
        $response = array_map(function ($stock) {
            return [
                $stock['ingredient']['name'] => $stock['quantity'],
            ];
        }, $response);
        return [
            'data' => $response,
        ];
    }
}
