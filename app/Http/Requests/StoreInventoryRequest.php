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
            'asset_tagging' => 'required|string|max:255',
            'jenis_aset' => 'required|exists:inventory,id',
            'merk' => 'required|exists:merk,id',
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'nama' => 'nullable|string|max:255',
            'mapping' => 'nullable|string|max:255',
            'o365' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'kondisi' => 'nullable|in:Good,Exception,Bad',
            'detail_kondisi' => 'nullable|string',
            'estimasi_perbaikan' => 'nullable|numeric',
        ];
    }
}
