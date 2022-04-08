<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;

class CreateController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return Response::view('roles.create', [
            'permissions' => Permission::all(),
        ]);
    }
}
