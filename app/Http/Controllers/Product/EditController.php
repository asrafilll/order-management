<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product)
    {
        $product->load(['options', 'variants']);

        return Response::view('products.edit', [
            'product' => $product,
        ]);
    }
}
