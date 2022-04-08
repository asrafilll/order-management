<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        DB::transaction(function () use ($storeRequest) {
            /** @var Role */
            $role = Role::create($storeRequest->safe()->only(['name']));

            if ($storeRequest->filled('permissions')) {
                $role->syncPermissions($storeRequest->safe()->only(['permissions']));
            }
        });

        $message = __('crud.created', [
            'name' => 'role',
        ]);

        return Response::redirectToRoute('roles.index')
            ->with('success', $message);
    }
}
