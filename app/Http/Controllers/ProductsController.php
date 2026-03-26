<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'product_description' => 'required',
            'product_image' => 'required|image|max:2048',
            'product_link' => 'required|url',
            'product_discount' => 'required|numeric|min:0|max:100'
        ]);

        $file = $request->file('product_image');

        Storage::disk('public')->put(
            'products/' . $file->hashName(),
            fopen($file->getPathname(), 'r')
        );

        $validated['product_image'] = 'products/' . $file->hashName();

        $product = $productsService->create($validated);

        return $this->success('product created', $product, 201);
    }

    public function index(Request $request, ProductsService $productsService)
    {
        return $productsService->getProducts($request);
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
