<?php

namespace App\Http\Controllers;

use App\Models\InventoryHistory;
use Illuminate\Http\Request;

class InventoryHistoryController extends Controller
{
    // Membaca semua data inventory history
    public function index()
    {
        $inventory_histories = InventoryHistory::all();
        return view('inventorys.history', compact('inventory_histories'));
    }
    
    

}
