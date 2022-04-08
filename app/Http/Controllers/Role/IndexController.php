<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Role;

class IndexController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $roles = Role::query()
            ->paginate(
                perPage: $request->get('per_page', 10),
                page: $request->get('page')
            );

        return Response::view('roles.index', [
            'roles' => $roles,
        ]);
    }
}
