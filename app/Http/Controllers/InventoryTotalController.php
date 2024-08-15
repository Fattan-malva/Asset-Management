<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\Merk;
use Illuminate\Http\Request;

class InventoryTotalController extends Controller
{
    // Existing methods...

    public function summary()
    {
        // Fetch summary of inventory with total quantity
        $inventorySummary = DB::table('inventory as i')
        ->join('merk as m', 'i.merk', '=', 'm.id')
        ->select('i.asets', 'm.name as merk', DB::raw('COUNT(*) as total_quantity'))
        ->groupBy('i.asets', 'm.name')
        ->orderBy('i.asets')
        ->orderBy('m.name')
        ->get();
        return view('inventorys.total', compact('inventorySummary'));
    }
}
