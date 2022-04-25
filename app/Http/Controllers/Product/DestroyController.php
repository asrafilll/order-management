<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product)
    {
        $product->delete();

        $message = __('crud.deleted', [
            'name' => 'product',
        ]);

        return Response::redirectToRoute('products.index')
            ->with('success', $message);
    }
}
