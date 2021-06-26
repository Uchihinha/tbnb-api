<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'products' => 'required|array',
            'products.*' => 'required|numeric|exists:products,id',
            'stock_quantity' => 'required_without:price|numeric',
            'price' => 'required_without:stock_quantity|numeric'
        ];
    }
}
