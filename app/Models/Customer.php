<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Table name
    protected $table = 'customer'; 

    // Fillable fields
    protected $fillable = [
        'username',
        'password',
        'role',
        'nrp', 
        'name', 
        'mapping'
    ];

    // Relationships
    public function assets()
    {
        return $this->hasMany(Assets::class, 'nama'); // Adjust if needed
    }

    // Optional: If you don't use timestamps
    public $timestamps = false;
}
