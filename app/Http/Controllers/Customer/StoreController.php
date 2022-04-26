<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        $customer = Customer::create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'customer',
        ]);

        return Response::redirectToRoute('customers.edit', $customer)
            ->with('success', $message);
    }
}
