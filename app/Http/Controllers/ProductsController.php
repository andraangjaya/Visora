<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductsService;
use Illuminate\Http\Request;

class ProductsController extends BaseApiController
{
    public function store(Request $request, ProductsService $productsService)
    {
        $user = auth()->user();

        if ($user->role !== 'admin') {
            return response()->json([
                'error' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
            'product_stock' => 'required',
            'product_description' => 'required'
        ]);

        $productsService->create($validated);

        return $this->success('product created', $validated, 201);
    }

    public function index()
    {
        return Product::all();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, ProductsService $productsService, Product $product)
    {

        $validated = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
            'product_stock' => 'required',
        ]);

        $productsService->update($validated, $product);

        return $this->success('product updated', $validated);
    }

    public function destroy(ProductsService $productsService, Product $product)
    {
        $productsService->delete($product);

        return $this->success('product deleted', $product);

    }

}
