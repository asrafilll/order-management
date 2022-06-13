<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductBestSellerResource;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;

class ProductBestSellerController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        /** @var Carbon */
        $now = Carbon::now();

        return ProductBestSellerResource::collection(
            OrderItem::query()
                ->selectRaw('order_items.product_id as id, ANY_VALUE(order_items.product_name) as name, CAST(SUM(order_items.quantity) AS UNSIGNED) as total')
                ->join('orders', 'order_items.order_id', 'orders.id')
                ->whereYear('orders.created_at', $now->year)
                ->whereMonth('orders.created_at', $now->month)
                ->groupBy('product_id')
                ->orderByDesc('total')
                ->limit(10)
                ->get()
        );
    }
}
