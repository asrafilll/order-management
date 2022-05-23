<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderStatusOrderResource;
use App\Models\Order;
use Illuminate\Support\Carbon;

class OrderStatusOrderController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return OrderStatusOrderResource::collection(
            Order::query()
                ->selectRaw('UPPER(status) as name, COUNT(id) as total_orders')
                ->groupBy('status')
                ->get()
        );
    }
}
