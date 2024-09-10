<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    // Table name
    protected $table = 'assets'; 

    // Fillable fields
    protected $fillable = [
        'asset_tagging',
        'jenis_aset',
        'merk',
        'type',
        'serial_number',
        'nama',
        'mapping',
        'o365',
        'lokasi',
   
        'status',
        'approval_status',
        'aksi',
        'kondisi',
        'documentation',
        'previous_customer_name',
        'latitude',
        'longitude'
    ];

    // Relationships
    public function merk()
    {
        return $this->belongsTo(Merk::class, 'merk');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'nama'); // Adjust if needed
    }

    // Optional: If you have timestamps
    public $timestamps = true;
}
