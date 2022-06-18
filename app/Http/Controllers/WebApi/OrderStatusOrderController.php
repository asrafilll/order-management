<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderStatusOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusOrderController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return OrderStatusOrderResource::collection(
            Order::query()
                ->selectRaw('UPPER(status) as name, COUNT(id) as total_orders')
                ->when($request->filled('start_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(created_at) >= ?', [$request->get('start_date')]);
                })
                ->when($request->filled('end_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(created_at) <= ?', [$request->get('end_date')]);
                })
                ->groupBy('status')
                ->get()
        );
    }
}
