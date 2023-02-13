<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProvinceBestSellerResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ProvinceBestSellerController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return ProvinceBestSellerResource::collection(
            OrderItem::query()
                ->selectRaw('orders.customer_province as name, CAST(SUM(order_items.quantity) AS UNSIGNED) as total')
                ->join('orders', 'order_items.order_id', 'orders.id')
                ->when($request->filled('start_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(orders.closing_date) >= ?', [$request->get('start_date')]);
                })
                ->when($request->filled('end_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(orders.closing_date) <= ?', [$request->get('end_date')]);
                })
                ->groupBy('name')
                ->orderByDesc('total')
                ->limit(10)
                ->get()
        );
    }
}
