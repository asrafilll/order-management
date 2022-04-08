<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;

class EditController extends Controller
{
    /**
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Role $role)
    {
        $role->load(['permissions']);

        return Response::view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::all(),
        ]);
    }
}
