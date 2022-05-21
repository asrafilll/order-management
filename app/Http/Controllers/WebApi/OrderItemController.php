<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return OrderItemResource::collection(
            OrderItem::query()
                ->when($request->filled('q'), function ($query) use ($request) {
                    $query->where(function ($whereQuery) use ($request) {
                        $whereQuery
                            ->orWhere('product_name', 'LIKE', '%' . $request->get('q') . '%')
                            ->orWhere('variant_name', 'LIKE', '%' . $request->get('q') . '%');
                    });
                })
                ->when($request->filled('order_id'), function ($query) use ($request) {
                    $query->where('order_id', $request->get('order_id'));
                })
                ->paginate(
                    perPage: $request->get('per_page', 10),
                    page: $request->get('page')
                )
        );
    }
}
