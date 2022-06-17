<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
        ];

        return CustomerResource::collection(
            Customer::query()
                ->when($request->filled('q'), function ($query) use ($request, $filters) {
                    $query->where(function ($query) use ($request, $filters) {
                        foreach ($filters as $filter) {
                            $query->orWhere($filter, 'LIKE', "%{$request->get('q')}%");
                        }
                    });
                })
                ->paginate(
                    perPage: $request->get('per_page'),
                    page: $request->get('page')
                )
        );
    }
}
