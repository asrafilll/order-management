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
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query
                        ->orWhere('status', 'LIKE', '%' . $request->get('search') . '%')
                        ->orWhere('source_name', 'LIKE', '%' . $request->get('search') . '%')
                        ->orWhere('payment_status', 'LIKE', '%' . $request->get('search') . '%')
                        ->orWhere('customer_name', 'LIKE', '%' . $request->get('search') . '%')
                        ->orWhere('items_quantity', 'LIKE', '%' . $request->get('search') . '%')
                        ->orWhere('total_price', 'LIKE', '%' . $request->get('search') . '%');
                });
            })
            ->paginate(
                perPage: $request->get('per_page', 10),
                page: $request->get('page')
            );

        return Response::view('orders.index', [
            'orders' => $orders,
        ]);
    }
}
