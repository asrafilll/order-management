<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $filters = [
            'name',
            'phone',
            'type',
        ];

        $customers = Customer::query()
            ->when($request->filled('search'), function ($query) use ($request, $filters) {
                $query->where(function ($query) use ($request, $filters) {
                    foreach ($filters as $filter) {
                        $query->orWhere($filter, 'LIKE', "%{$request->get('search')}%");
                    }
                });
            })
            ->paginate(
                perPage: $request->get('per_page', 10),
                page: $request->get('page')
            );

        return Response::view('customers.index', [
            'customers' => $customers,
        ]);
    }
}
