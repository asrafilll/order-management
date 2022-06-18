<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderSourceOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderSourceOrderController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return OrderSourceOrderResource::collection(
            Order::query()
                ->selectRaw("source_id as id, source_name as name, COUNT(id) as total_orders")
                ->when($request->filled('start_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(created_at) >= ?', [$request->get('start_date')]);
                })
                ->when($request->filled('end_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(created_at) <= ?', [$request->get('end_date')]);
                })
                ->groupByRaw("source_id, source_name")
                ->get()
        );
    }
}
