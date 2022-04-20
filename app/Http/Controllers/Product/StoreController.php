<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        $product = DB::transaction(function () use ($storeRequest) {
            /** @var Product */
            $product = Product::create($storeRequest->getProductAttribute());
            $product->options()->createMany($storeRequest->getProductOptionsAttributes());
            $product->variants()->createMany($storeRequest->getProductVariantsAttributes());

            return $product;
        });

        $message = __('crud.created', [
            'name' => 'product'
        ]);

        return Response::redirectToRoute('products.edit', ['product' => $product])
            ->with('success', $message);
    }
}
