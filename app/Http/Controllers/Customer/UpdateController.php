<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param Customer $customer
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Customer $customer, UpdateRequest $updateRequest)
    {
        $customer->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'customer',
        ]);

        return Response::redirectToRoute('customers.edit', $customer)
            ->with('success', $message);
    }
}
