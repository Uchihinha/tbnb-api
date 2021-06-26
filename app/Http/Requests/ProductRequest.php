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
            'price' => 'required|numeric',
            'sku' => 'string',
            'barcode' => 'string',
            'stock_quantity' => 'required|numeric'
        ];
    }
}
