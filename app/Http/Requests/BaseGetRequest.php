<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseGetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'page' => 'numeric',
            'paginate' => 'numeric'
        ];
    }
}
