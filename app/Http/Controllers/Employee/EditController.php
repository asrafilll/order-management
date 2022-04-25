<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Employee $employee)
    {
        return Response::view('employees.edit', [
            'employee' => $employee,
        ]);
    }
}
