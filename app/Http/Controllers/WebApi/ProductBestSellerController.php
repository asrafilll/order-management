<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductBestSellerResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ProductBestSellerController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return ProductBestSellerResource::collection(
            OrderItem::query()
                ->selectRaw('order_items.product_id as id, order_items.product_name as name, CAST(SUM(order_items.quantity) AS UNSIGNED) as total')
                ->join('orders', 'order_items.order_id', 'orders.id')
                ->when($request->filled('start_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(orders.created_at) >= ?', [$request->get('start_date')]);
                })
                ->when($request->filled('end_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(orders.created_at) <= ?', [$request->get('end_date')]);
                })
                ->groupByRaw('product_id, name')
                ->orderByDesc('total')
                ->limit(10)
                ->get()
        );
    }
}
