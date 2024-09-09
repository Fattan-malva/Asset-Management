<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\Merk;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        // Fetch inventory with merk name
        $inventorys = DB::table('inventory')
            ->join('merk', 'inventory.merk', '=', 'merk.id')
            ->select('inventory.*', 'merk.name as merk_name')
            ->get();

        return view('inventorys.index', compact('inventorys'));
    }

    public function create()
    {
        $merkes = Merk::all(); // Fetch all Merk records
        return view('inventorys.create', compact('merkes')); // Pass 'merkes' to the view
    }

    public function store(Request $request)
    {
        $request->validate([
            'tagging' => 'required|string|max:255|unique:inventory,tagging',
            'asets' => 'required|string|max:255',
            'merk' => 'required|exists:merk,id',
            'seri' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'kondisi' => 'required|in:Good,Exception,Bad',
        ]);

        Inventory::create([
            'asets' => $request->asets,
            'merk' => $request->merk,
            'tagging' => $request->tagging,
            'seri' => $request->seri,
            'type' => $request->type,
            'kondisi' => $request->kondisi,
        ]);

        return redirect()->route('inventorys.index')->with('success', 'Asset created successfully.');
    }

    public function edit($id)
    {
        // Fetch inventory item with merk name
        $inventory = DB::table('inventory')
            ->join('merk', 'inventory.merk', '=', 'merk.id')
            ->select('inventory.*', 'merk.name as merk_name')
            ->where('inventory.id', $id)
            ->first();

        // Fetch all merk names
        $merks = DB::table('merk')->pluck('name', 'id');

        return view('inventorys.edit', compact('inventory', 'merks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tagging' => 'required|string|max:255|unique:inventory,tagging,' . $id,
            'asets' => 'required|string|max:255',
            'merk' => 'required|exists:merk,id',
            'seri' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'kondisi' => 'required|in:Good,Exception,Bad',
        ]);

        $inventory = Inventory::findOrFail($id);

        $inventory->asets = $request->input('asets');
        $inventory->merk = $request->input('merk');
        $inventory->tagging = $request->input('tagging'); // Include tagging here
        $inventory->seri = $request->input('seri');
        $inventory->type = $request->input('type');
        $inventory->kondisi = $request->input('kondisi');
        $inventory->save();

        return redirect()->route('inventorys.index')->with('success', 'Asset updated successfully');
    }

    public function destroy($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->delete();

            return redirect()->route('inventorys.index')->with('success', 'Asset deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') { // Foreign key constraint violation
                return redirect()->route('inventorys.index')->with('error', 'Cannot delete this inventory as it is being used by other records.');
            }
            return redirect()->route('inventorys.index')->with('error', 'An error occurred while deleting the inventory.');
        }
    }
    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventory.show', compact('inventory'));
    }
    

}
