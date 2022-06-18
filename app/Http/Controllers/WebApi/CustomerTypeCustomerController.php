<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerTypeCustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerTypeCustomerController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return CustomerTypeCustomerResource::collection(
            Customer::query()
                ->selectRaw('UPPER(type) as name, COUNT(id) as total_customers')
                ->when($request->filled('start_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(created_at) >= ?', [$request->get('start_date')]);
                })
                ->when($request->filled('end_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(created_at) <= ?', [$request->get('end_date')]);
                })
                ->groupBy('type')
                ->get()
        );
    }
}
