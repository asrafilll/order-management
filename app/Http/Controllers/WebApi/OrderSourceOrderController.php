<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderSourceOrderResource;
use App\Models\Order;
use App\Models\OrderSource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class OrderSourceOrderController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var Collection */
        $orderSources = OrderSource::query()
            ->whereNull('parent_id')
            ->get();

        $orderSourceOrders = $orderSources->reduce(function ($occ, $orderSource) {
            $totalParentOrders = Order::query()
                ->where('source_id', $orderSource->id)
                ->count();

            /** @var Collection */
            $childOrderSources = OrderSource::query()
                ->where('parent_id', $orderSource->id)
                ->get();

            $totalChildOrders = Order::query()
                ->whereIn('source_id', $childOrderSources->pluck('id')->all())
                ->count();

            $totalOrders = $totalParentOrders + $totalChildOrders;

            if (!$totalOrders) {
                return $occ;
            }

            $occ->push([
                'id' => $orderSource->id,
                'name' => $orderSource->name,
                'total_orders' => $totalOrders,
            ]);

            return $occ;
        }, Collection::make());

        return OrderSourceOrderResource::collection($orderSourceOrders);
    }
}
