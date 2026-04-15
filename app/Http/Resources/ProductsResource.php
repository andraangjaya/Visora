<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'product_price' => $this->product_price,
            'product_stock' => $this->product_stock,
            'product_description' => $this->product_description,
            'product_feature' => $this->product_feature,
            'product_image' => $this->product_image,
            'product_image_url' => asset('storage/' . $this->product_image),
            'product_link' => $this->product_link,
            'product_discount' => $this->product_discount,
            'final_price' => $this->final_price,
        ];
    }
}
