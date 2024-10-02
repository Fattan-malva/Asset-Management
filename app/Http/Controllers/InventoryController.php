<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\Merk;
use App\Models\InventoryHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


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
        // Validasi input
        $request->validate([
            'tagging' => 'required|string|max:255|unique:inventory,tagging',
            'asets' => 'required|string|max:255',
            'merk' => 'required|exists:merk,id',
            'seri' => 'required|string|max:255',
            'tanggalmasuk' => 'required|date',  // Validasi sebagai tanggal
            'type' => 'required|string|max:255',
            'kondisi' => 'required|in:Good,Exception,Bad,New',
            'documentation' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048' // Validasi file dokumentasi
        ]);

        // Konversi tanggal ke format yang diinginkan (jika perlu)
        $formattedDate = Carbon::parse($request->tanggalmasuk)->format('Y-m-d'); // Simpan dalam format tanggal yang standar

        // Simpan data ke database
        $inventory = Inventory::create([
            'asets' => $request->asets,
            'merk' => $request->merk,
            'tagging' => $request->tagging,
            'seri' => $request->seri,
            'tanggalmasuk' => $formattedDate, // Menyimpan dalam format tanggal
            'type' => $request->type,
            'kondisi' => $request->kondisi,
        ]);

        // Handle the uploaded documentation file
        $documentationPath = null;
        if ($request->hasFile('documentation')) {
            $file = $request->file('documentation');
            $documentationPath = 'documentation/' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documentation'), $documentationPath);
        }

        // Simpan data ke inventory_history
        InventoryHistory::create([
            'inventory_id' => $inventory->id, // ID dari inventory yang baru saja dibuat
            'action' => 'INSERT', // Tindakan yang dilakukan
            'tagging' => $inventory->tagging,
            'asets' => $inventory->asets,
            'merk' => $inventory->merk,
            'seri' => $inventory->seri,
            'tanggalmasuk' => $inventory->tanggalmasuk,
            'type' => $inventory->type,
            'kondisi' => $inventory->kondisi,
            'documentation' => $documentationPath, // Simpan path dokumentasi
        ]);

        // Redirect ke halaman index dengan pesan sukses
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
            'maintenance' => 'required|string|max:255',
            'kondisi' => 'required|in:Good,Exception,Bad,New',
        ]);

        $inventory = Inventory::findOrFail($id);

        $inventory->asets = $request->input('asets');
        $inventory->merk = $request->input('merk');
        $inventory->tagging = $request->input('tagging'); // Include tagging here
        $inventory->seri = $request->input('seri');
        $inventory->type = $request->input('type');
        $inventory->kondisi = $request->input('kondisi');
        $inventory->maintenance = $request->input('maintenance');
        $inventory->save();

        return redirect()->route('inventorys.index')->with('success', 'Asset updated successfully');
    }
    public function destroy(Request $request)
    {
        $ids = $request->input('ids');
        $documentationPath = null;

        // Handle the uploaded documentation file
        if ($request->hasFile('documentation')) {
            $file = $request->file('documentation');
            $documentationPath = 'documentation/' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documentation'), $documentationPath);
        }

        try {
            foreach ($ids as $id) {
                // Find and delete the inventory
                $inventory = Inventory::findOrFail($id);

                // Create a record in the inventory_history
                InventoryHistory::create([
                    'inventory_id' => $id,
                    'action' => 'DELETE',
                    'tagging' => $inventory->tagging,
                    'asets' => $inventory->asets,
                    'merk' => $inventory->merk,
                    'seri' => $inventory->seri,
                    'tanggalmasuk' => $inventory->tanggalmasuk,
                    'type' => $inventory->type,
                    'kondisi' => $inventory->kondisi,
                    'status' => $inventory->status,
                    'lokasi' => $inventory->lokasi,
                    'tanggal_diterima' => $inventory->tanggal_diterima,
                    'documentation' => $documentationPath, // Save the documentation path
                ]);

                // Now delete the inventory
                $inventory->delete();
            }

            return redirect()->route('inventory.history')->with('success', 'Assets scrapped successfully.');
        } catch (\Exception $e) {
            return redirect()->route('inventory.history')->with('error', 'An error occurred while deleting the asset: ' . $e->getMessage());
        }
    }



    public function showScrapForm()
    {
        // Fetch all inventory items for display in the select dropdown
        $inventories = Inventory::all();

        // Return the scrap view with the inventory data
        return view('inventorys.scrap', compact('inventories'));
    }

    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventory.show', compact('inventory'));
    }


}
