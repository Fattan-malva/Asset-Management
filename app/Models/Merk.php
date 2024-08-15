<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    protected $table = 'merk'; // Sesuaikan dengan nama tabel yang ada di database

    protected $fillable = [
        'name',
    ];

    // Relasi dengan Inventory
    public function inventorys()
    {
        return $this->hasMany(Inventory::class);
    }
    public $timestamps = false;
}
