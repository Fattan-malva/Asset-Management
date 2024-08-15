<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'asets' => 'required|string|max:255',
            'merk' => 'required|exists:merkes,id',
            'quantity' => 'required|integer',
        ];
    }
}
