<?php

namespace Tests\Utils;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductVariant;

trait ProductFactory
{
    public function createProduct(): Product
    {
        return Product::factory()
            ->has(ProductOption::factory()->count(1), 'options')
            ->has(ProductVariant::factory()->count(3), 'variants')
            ->create();
    }
}
