<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Response::view('products.index', [
            'products' => Product::query()
                ->when(
                    $request->filled('search'),
                    function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $value = '%' . $request->get('search') . '%';
                            $query->orWhere('name', 'LIKE', $value);
                        });
                    }
                )
                ->paginate(perPage: $request->get('per_page', 10)),
        ]);
    }
}
