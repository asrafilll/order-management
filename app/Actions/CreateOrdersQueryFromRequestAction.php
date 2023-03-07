<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\OrderSource;
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
            'sales_id',
            'customer_type',
            'payment_method_id',
            'shipping_id',
            'customer_province',
            'customer_city',
            'customer_subdistrict',
            'customer_village',
        ];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->get($filter));
            }
        }

        if ($request->filled('source_id')) {
            /** @var OrderSource */
            $orderSource = OrderSource::with(['child'])->find($request->get('source_id'));

            if ($orderSource->child->count() < 1) {
                $query->where('source_id', $orderSource->id);
            } else {
                $query->whereIn('source_id', $orderSource->child->pluck('id'));
            }
        }

        if ($request->filled('variant_id') || $request->filled('variant_name')) {
            $query->whereExists(function ($query) use ($request) {
                $query->selectRaw(1)
                    ->from('order_items')
                    ->whereColumn('order_items.order_id', 'orders.id')
                    ->where(function ($query) use ($request) {
                        $query->when($request->filled('variant_id'), function ($query) use ($request) {
                            $query->orWhere('order_items.variant_id', $request->get('variant_id'));
                        })
                        ->when($request->filled('variant_name'), function ($query) use ($request) {
                            $query->orWhere('order_items.product_name', 'LIKE', '%' . $request->get('variant_name') . '%');
                        });
                    });
            });
        }

        if ($request->filled('start_date')) {
            $query->whereRaw('DATE(created_at) >= ?', [$request->get('start_date')]);
        }

        if ($request->filled('end_date')) {
            $query->whereRaw('DATE(created_at) <= ?', [$request->get('end_date')]);
        }

        return $query;
    }
}
