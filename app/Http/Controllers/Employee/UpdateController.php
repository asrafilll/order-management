<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\UpdateRequest;
use App\Models\Employee;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param Employee $employee
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Employee $employee, UpdateRequest $updateRequest)
    {
        $employee->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'employee',
        ]);

        return Response::redirectToRoute('employees.edit', $employee)
            ->with('success', $message);
    }
}
