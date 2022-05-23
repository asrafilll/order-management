<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerTypeCustomerResource;
use App\Models\Customer;

class CustomerTypeCustomerController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return CustomerTypeCustomerResource::collection(
            Customer::query()
                ->selectRaw('UPPER(type) as name, COUNT(id) as total_customers')
                ->groupBy('type')
                ->get()
        );
    }
}
