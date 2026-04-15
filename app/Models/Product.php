<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_price',
        'product_stock',
        'product_description',
        'product_feature',
        'product_image',
        'product_link',
        'product_discount'
    ];

    protected $casts = [
        'product_feature' => 'array',
    ];

    protected $appends = ['final_price'];

    public function getFinalPriceAttribute(){
        return $this->product_price - ($this->product_discount / 100 * $this->product_price);
    }

}
