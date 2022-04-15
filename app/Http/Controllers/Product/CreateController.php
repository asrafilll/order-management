<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class CreateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        switch ($request->get('action')) {
            case 'add-option':
                return Response::view('products.components.option', [
                    'index' => $request->get('index'),
                ]);
            case 'generate-variants':
                return $this->generateVariants($request);
            default:
                return Response::view('products.create');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function generateVariants(Request $request)
    {
        $variants = Collection::make();

        if ($request->filled('values1')) {
            $values1 = Str::of($request->get('values1'))->explode('|');

            foreach ($values1 as $value1) {
                if (!$request->filled('values2') && strlen($value1) > 0) {
                    $variants->push($value1);
                } else {
                    $values2 = Str::of($request->get('values2'))->explode('|');

                    foreach ($values2 as $value2) {
                        if (!$request->filled('values3') && strlen($value2) > 0) {
                            $variants->push(implode(' / ', [
                                $value1,
                                $value2,
                            ]));
                        } else {
                            $values3 = Str::of($request->get('values3'))->explode('|');

                            foreach ($values3 as $value3) {
                                if (strlen($value3) > 0) {
                                    $variants->push(implode(' / ', [
                                        $value1,
                                        $value2,
                                        $value3,
                                    ]));
                                }
                            }
                        }
                    }
                }
            }
        }

        return Response::view('products.components.variants', [
            'variants' => $variants,
        ]);
    }
}
