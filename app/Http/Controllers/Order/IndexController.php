<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $orders = Order::query()
            ->latest()
            ->paginate(
                perPage: $request->get('per_page', 10),
                page: $request->get('page')
            );

        return Response::view('orders.index', [
            'orders' => $orders,
        ]);
    }
}
