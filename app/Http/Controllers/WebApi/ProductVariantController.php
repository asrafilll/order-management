<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductVariantResource;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return ProductVariantResource::collection(
            ProductVariant::query()
                ->select([
                    'product_variants.*',
                    'products.slug as product_slug',
                    'products.name as product_name',
                    'products.description as product_description',
                    'products.status as product_status',
                ])
                ->join('products', 'product_variants.product_id', '=', 'products.id')
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('products.status', $request->get('status'));
                })
                ->when($request->filled('q'), function ($query) use ($request) {
                    $query->where('products.name', 'LIKE', '%' . $request->get('q') . '%');
                })
                ->orderBy('products.name')
                ->paginate(
                    perPage: $request->get('per_page')
                )
        );
    }
}
