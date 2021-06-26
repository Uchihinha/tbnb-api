<?php

namespace App\Models;

class ProductStockHistory extends BaseModel
{
    protected $fillable = [
        'product_id',
        'old_quantity',
        'new_quantity'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
