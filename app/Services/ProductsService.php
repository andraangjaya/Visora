<?php

namespace App\Services;

use App\Models\Product;

class ProductsService
{
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function getProducts($request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if($request->minPrice){
            $query->where('price', '>=', $request->minPrice);
        }

        if($request->maxPrice){
            $query->where('price', '<=', $request->maxPrice);
        }

        if($request->sortBy){
            $query->orderBy($request->sortBy, $request->direction);
        }

        return $query->paginate(10);
    }

    public function update(array $data, Product $product): Product
    {
        $product->update($data);
        return $product;
    }

    public function updateStock(int $stock, Product $product): Product{
        $product->update([
            'product_stock' => $stock
        ]);
        return $product;
    }

    public function delete(Product $product): Product
    {
        $product->delete();
        return $product;
    }
}
