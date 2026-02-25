<?php

namespace App\Services;

use App\Models\Product;

class ProductsService
{
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(array $data, Product $product): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): Product
    {
        $product->delete();
        return $product;
    }
}
