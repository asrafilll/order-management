<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param Product $product
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product, UpdateRequest $updateRequest)
    {
        $product = DB::transaction(function () use ($product, $updateRequest) {
            $product->load(['options', 'variants']);
            $product->update($updateRequest->getProductAttribute());
            $this->syncProductOptions(
                $product,
                $updateRequest
            );
            $this->syncProductVariants(
                $product,
                $updateRequest
            );

            return $product;
        });

        $message = __('crud.updated', [
            'name' => 'product',
        ]);

        return Response::redirectToRoute('products.edit', $product)
            ->with('success', $message);
    }

    private function syncProductOptions(
        Product $product,
        UpdateRequest $updateRequest
    ) {
        $productOptionsAttributes = $updateRequest->getProductOptionsAttributes();
        /** @var ProductOption */
        $productOption1 = $product->options->first();
        if (!is_null($productOption1)) {
            $productOption1->update($productOptionsAttributes[0]);
        } else {
            $productOption1 = $product
                ->options()
                ->create($productOptionsAttributes[0]);
        }

        /** @var ProductOption */
        $productOption2 = $product
            ->options
            ->where('id', '!=', $productOption1->id)
            ->first();

        if (
            isset($productOptionsAttributes[1]) &&
            !is_null($productOptionsAttributes[1]['name']) &&
            !is_null($productOptionsAttributes[1]['values'])
        ) {
            if (is_null($productOption2)) {
                $product
                    ->options()
                    ->create($productOptionsAttributes[1]);
            } else {
                $productOption2->update($productOptionsAttributes[1]);
            }
        } else {
            if ($productOption2) {
                $productOption2->delete();
            }
        }

        $product->load(['options']);
    }

    private function syncProductVariants(
        Product $product,
        UpdateRequest $updateRequest
    ) {
        foreach ($updateRequest->getProductVariantsAttributes() as $productVariantAttribute) {
            if (!is_null($productVariantAttribute['id'])) {
                $productVariantId = $productVariantAttribute['id'];

                unset($productVariantAttribute['id']);

                $product
                    ->variants()
                    ->where('id', $productVariantId)
                    ->update($productVariantAttribute);
            } else {
                $productVariantId = $productVariantAttribute['id'];

                unset($productVariantAttribute['id']);

                $product
                    ->variants()
                    ->create($productVariantAttribute);
            }
        }

        $product->load(['variants']);

        /** @var ProductOption */
        $productOption1 = $product
            ->options
            ->first();
        $productOption1ArrayValues = json_decode($productOption1->values);
        /** @var ProductOption|null */
        $productOption2 = $product
            ->options
            ->where('id', '!=', $productOption1->id)
            ->first();
        $productOption2ArrayValues = !is_null($productOption2)
            ? json_decode($productOption2->values)
            : [];

        foreach ($product->variants as $productVariant) {
            if (
                !in_array($productVariant->value1, $productOption1ArrayValues)
                || (count($productOption2ArrayValues) > 0
                    && !in_array($productVariant->value2, $productOption2ArrayValues)
                )
            ) {
                $productVariant->delete();
            }
        }
    }
}
