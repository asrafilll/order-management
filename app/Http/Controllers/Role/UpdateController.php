<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\UpdateRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param Role $role
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Role $role, UpdateRequest $updateRequest)
    {
        $role->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'role',
        ]);

        return Response::redirectToRoute('roles.edit', $role)
            ->with('success', $message);
    }
}
