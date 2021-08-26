<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

/** @see \App\Models\Order */
class OrderCollection extends ResourceCollection
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $response = parent::toArray($request);

        $response = array_map(function ($order) {
            return [
                'id' => $order['id'],
                'recipe' => $order['recipe']['name'],
                'status' => $order['status'],
                'created_at' => $order['created_at'],
            ];
        }, $response);
        return [
            'data' => $response,
        ];
    }
}
