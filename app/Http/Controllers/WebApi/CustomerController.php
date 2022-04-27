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
        return CustomerResource::collection(
            Customer::query()
                ->when($request->filled('q'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->get('q') . '%');
                })
                ->paginate(
                    perPage: $request->get('per_page'),
                    page: $request->get('page')
                )
        );
    }
}
