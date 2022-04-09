<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Response;

class CreateController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return Response::view('users.create', [
            'roles' => Role::all(),
        ]);
    }
}
