<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreRequest;
use App\Models\Employee;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        $employee = Employee::create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'employee',
        ]);

        return Response::redirectToRoute('employees.edit', $employee)
            ->with('success', $message);
    }
}
