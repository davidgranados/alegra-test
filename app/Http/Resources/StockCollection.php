<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Stock */
class StockCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
