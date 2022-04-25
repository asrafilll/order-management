<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Employee $employee)
    {
        $employee->delete();
        $message = __('crud.deleted', [
            'name' => 'role',
        ]);

        return Response::redirectToRoute('employees.index')
            ->with('success', $message);
    }
}
