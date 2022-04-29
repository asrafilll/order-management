<?php

namespace App\Http\Controllers\Order\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\Item\StoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param Order $order
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order, StoreRequest $storeRequest)
    {
        /** @var ProductVariant */
        $productVariant = ProductVariant::find($storeRequest->get('variant_id'));
        $productVariant->load(['product']);
        /** @var OrderItem */
        $orderItem = $order
            ->items()
            ->where('variant_id', $storeRequest->get('variant_id'))
            ->first();

        if ($orderItem) {
            $orderItem->increment('quantity');
        } else {
            $order
                ->items()
                ->create([
                    'product_id' => $productVariant->product_id,
                    'product_slug' => $productVariant->product->slug,
                    'product_name' => $productVariant->product->name,
                    'product_description' => $productVariant->product->description,
                    'variant_id' => $productVariant->id,
                    'variant_name' => $productVariant->name,
                    'variant_price' => $productVariant->price,
                    'variant_weight' => $productVariant->weight,
                    'variant_option1' => $productVariant->option1,
                    'variant_value1' => $productVariant->value1,
                    'variant_option2' => $productVariant->option2,
                    'variant_value2' => $productVariant->value2,
                ]);
        }


        $message = __('crud.created', [
            'name' => 'order item',
        ]);

        return Response::redirectToRoute('orders.edit', $order)
            ->with('success', $message);
    }
}
