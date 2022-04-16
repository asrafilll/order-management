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

        if (!$request->filled('options')) {
            return Response::view('products.components.variants', [
                'variants' => $variants,
            ]);
        }

        parse_str($request->get('options'), $options);
        ['options' => $options] = $options;
        $optionValues = $this->getOptionValues($options);

        if (count($optionValues) < 1) {
            return Response::view('products.components.variants', [
                'variants' => $variants,
            ]);
        }

        foreach ($optionValues[0] as $value0) {
            if (!isset($optionValues[1])) {
                $variants->push($value0);
            } else {
                foreach ($optionValues[1] as $value1) {
                    if (!isset($optionValues[2])) {
                        $variants->push(implode(' / ', [
                            $value0,
                            $value1,
                        ]));
                    } else {
                        foreach ($optionValues[2] as $value2) {
                            $variants->push(implode(' / ', [
                                $value0,
                                $value1,
                                $value2,
                            ]));
                        }
                    }
                }
            }
        }

        return Response::view('products.components.variants', [
            'variants' => $variants,
        ]);
    }

    private function getOptionValues(array $options)
    {
        $values = [];

        for ($i = 0; $i < count($options); $i++) {
            $_values = Str::of($options[$i]['values']);

            if ($_values->length() < 1) {
                break;
            }

            $values[] = $_values
                ->explode('|')
                ->reduce(function ($acc, $value) {
                    if (strlen($value) > 0) {
                        $acc[] = $value;
                    }

                    return $acc;
                }, []);
        }

        return $values;
    }
}
