<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'barcode',
        'price',
        'stock_quantity',
    ];

    protected $casts = [
        'price' => 'float'
    ];

    protected static function booted() {
        static::created(function ($product) {
            $product->stockHistory()->create([
                'old_quantity' => 0,
                'new_quantity' => $product->stock_quantity
            ]);
        });

        static::updated(function ($product) {
            if ($product->getOriginal('stock_quantity') != $product->stock_quantity) {
                $product->stockHistory()->create([
                    'old_quantity' => $product->getOriginal('stock_quantity'),
                    'new_quantity' => $product->stock_quantity
                ]);
            }
        });
    }

    public function stockHistory() {
        return $this->hasMany(ProductStockHistory::class);
    }
}
