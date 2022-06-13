<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductOrderResource;
use App\Models\OrderItem;

class ProductOrderController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return ProductOrderResource::collection(
            OrderItem::query()
                ->selectRaw('product_id, ANY_VALUE(product_name) as product_name, SUM(quantity) as total')
                ->groupBy('product_id')
                ->orderByDesc('total')
                ->limit(10)
                ->get()
        );
    }
}
