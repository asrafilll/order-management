<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\VillageResource;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return VillageResource::collection(
            Village::query()
                ->when($request->filled('q'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->get('q') . '%');
                })
                ->when($request->filled('subdistrict_code'), function ($query) use ($request) {
                    $query->whereParent($request->get('subdistrict_code'));
                })
                ->paginate(
                    perPage: $request->get('per_page', 10),
                    page: $request->get('page')
                )
        );
    }
}
