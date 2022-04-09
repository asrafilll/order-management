<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Role $role)
    {
        abort_if($role->users()->count() > 0, \Illuminate\Http\Response::HTTP_FORBIDDEN);
        $role->delete();
        $message = __('crud.deleted', [
            'name' => 'role',
        ]);

        return Response::redirectToRoute('roles.index')
            ->with('success', $message);
    }
}
