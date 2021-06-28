<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'sku' => '',
            'barcode' => 'max:13',
            'stock_quantity' => 'required|numeric'
        ];
    }
}
