<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Models\ProductOption;
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
            $deletedValues = $this->syncProductOptionsAndGetDeletedValues(
                $product,
                $updateRequest
            );

            foreach ($deletedValues as ['number' => $number, 'name' => $name, 'value' => $value]) {
                $product->variants
                    ->where('option' . $number, '=', $name)
                    ->where('value' . $number, '=', $value)
                    ->first()
                    ->delete();
            }

            // Create created variants

            return $product;
        });

        $message = __('crud.updated', [
            'name' => 'product',
        ]);

        return Response::redirectToRoute('products.edit', $product)
            ->with('success', $message);
    }

    private function getDeletedValues(
        int $optionNumber,
        ProductOption $productOption,
        array $productOptionsAttribute = null
    ): array {
        $productOptionValues = json_decode($productOption->values);
        $values = !is_null($productOptionsAttribute)
            ? json_decode($productOptionsAttribute['values'])
            : [];

        $deletedValues = [];

        foreach ($productOptionValues as $productOptionValue) {
            if (!in_array($productOptionValue, $values)) {
                $deletedValues[] = [
                    'number' => $optionNumber,
                    'name' => $productOption->name,
                    'value' => $productOptionValue,
                ];
            }
        }

        return $deletedValues;
    }

    private function syncProductOptionsAndGetDeletedValues(
        Product $product,
        UpdateRequest $updateRequest
    ): array {
        $productOptionsAttributes = $updateRequest->getProductOptionsAttributes();
        /** @var ProductOption */
        $productOption1 = $product->options->first();
        $deletedValues = $this->getDeletedValues(
            1,
            $productOption1,
            $productOptionsAttributes[0]
        );
        $productOption1->update($productOptionsAttributes[0]);

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
                $deletedValues = array_merge($deletedValues, $this->getDeletedValues(
                    2,
                    $productOption2,
                    $productOptionsAttributes[1]
                ));

                $productOption2->update($productOptionsAttributes[1]);
            }
        } else {
            if ($productOption2) {
                $deletedValues = array_merge(
                    $deletedValues,
                    $this->getDeletedValues(
                        2,
                        $productOption2
                    )
                );
                $productOption2->delete();
            }
        }

        return $deletedValues;
    }
}
