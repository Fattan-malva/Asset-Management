<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Merk;

class InventoryHistory extends Model
{
    protected $table = 'inventory_history'; // Sesuaikan dengan nama tabel yang ada di database

    protected $fillable = [
        // tambahkan field yang diperlukan
    ];

    // Mendapatkan nama merk berdasarkan ID
    public function getMerkNameAttribute()
    {
        $merk = Merk::find($this->merk); // Ganti 'merk_id' dengan nama kolom ID merk Anda
        return $merk ? $merk->name : 'N/A'; // Mengembalikan nama merk atau 'N/A' jika tidak ditemukan
    }
}
