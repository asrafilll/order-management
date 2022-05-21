<?php

namespace App\Http\Controllers\ReturnOrderItem;

use App\Http\Controllers\Controller;
use App\Models\ReturnOrderItem;
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
        $returnOrderItems = ReturnOrderItem::query()
            ->select([
                'return_order_items.*',
                'order_items.product_id',
                'order_items.product_name',
                'order_items.variant_id',
                'order_items.variant_name',
                'orders.customer_name',
            ])
            ->join('order_items', 'return_order_items.order_item_id', 'order_items.id')
            ->join('orders', 'return_order_items.order_id', 'orders.id')
            ->paginate(
                perPage: $request->get('per_page', 10),
                page: $request->get('page')
            );

        return Response::view('return-order-items.index', [
            'returnOrderItems' => $returnOrderItems,
        ]);
    }
}
