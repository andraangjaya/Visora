<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductsResource;
use App\Models\Product;
use App\Services\ProductsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class ProductsController extends BaseApiController
{
    public function store(Request $request, ProductsService $productsService)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
            'product_stock' => 'required',
            'product_description' => 'required',
            'product_feature' => 'required|array',
            'product_feature.*' => 'string',
            'product_image' => 'required|image|max:3000',
            'product_link' => 'required|url',
            'product_discount' => 'required|numeric|min:0|max:100'
        ]);

        $file = $request->file('product_image');

        Storage::disk('public')->put(
            'products/' . $file->hashName(),
            fopen($file->getPathname(), 'r')
        );

        $validated['product_image'] = 'products/' . $file->hashName();

        $validated['product_description'] = Purifier::clean($request->product_description);

        $product = $productsService->create($validated);
        return $this->success('product created', new ProductsResource($product), 201);
    }

    public function index(Request $request, ProductsService $productsService)
    {
        return ProductsResource::collection($productsService->getProducts($request));
    }

    public function show(Product $product)
    {
        return new ProductsResource($product);
    }

    public function update(Request $request, ProductsService $productsService, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'sometimes|required',
            'product_price' => 'sometimes|required',
            'product_stock' => 'sometimes|required',
            'product_description' => 'sometimes|required',
            'product_feature' => 'sometimes|required|array',
            'product_feature.*' => 'string',
            'product_image' => 'sometimes|required|image|max:3000',
            'product_link' => 'sometimes|required|url',
            'product_discount' => 'sometimes|required|numeric|min:0|max:100'
        ]);

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');

            Storage::disk('public')->put(
                'products/' . $file->hashName(),
                fopen($file->getPathname(), 'r')
            );

            $validated['product_image'] = 'products/' . $file->hashName();
        }

        if ($request->has('product_description')) {
            $validated['product_description'] = Purifier::clean($request->product_description);
        }

        $productsService->update($validated, $product);
        return $this->success('product updated', new ProductsResource($product));
    }

    public function destroy(ProductsService $productsService, Product $product)
    {
        $productsService->delete($product);
        return $this->success('product deleted', $product);
    }

}
