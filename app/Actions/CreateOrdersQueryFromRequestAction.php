<?php

namespace App\Actions;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class CreateOrdersQueryFromRequestAction
{
    /**
     * @return Builder|EloquentBuilder|Relation
     */
    public function run(Request $request)
    {
        $query = Order::query()->latest();

        if ($request->filled('search')) {
            $query->where(function ($query) use ($request) {
                $query
                    ->orWhere('status', 'LIKE', '%' . $request->get('search') . '%')
                    ->orWhere('source_name', 'LIKE', '%' . $request->get('search') . '%')
                    ->orWhere('payment_status', 'LIKE', '%' . $request->get('search') . '%')
                    ->orWhere('customer_name', 'LIKE', '%' . $request->get('search') . '%')
                    ->orWhere('items_quantity', 'LIKE', '%' . $request->get('search') . '%')
                    ->orWhere('total_price', 'LIKE', '%' . $request->get('search') . '%');
            });
        }

        $filters = [
            'customer_id',
            'status',
            'payment_status',
            'source_id',
            'sales_id',
            'customer_type',
            'payment_method_id',
            'shipping_id',
        ];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->get($filter));
            }
        }

        return $query;
    }
}
