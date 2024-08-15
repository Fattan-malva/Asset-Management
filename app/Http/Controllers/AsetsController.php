<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Assets;
use App\Models\Inventory;
use App\Models\Merk;
use App\Models\Customer;
use Illuminate\Http\Request;

class AsetsController extends Controller
{
    public function index()
    {
        $assets = DB::table('assets')
            ->join('merk', 'assets.merk', '=', 'merk.id')
            ->join('customer', 'assets.nama', '=', 'customer.id')
            ->join('inventory', 'assets.asset_tagging', '=', 'inventory.id') // Join inventory to get tagging
            ->select(
                'assets.*',
                'merk.name as merk_name',
                'customer.name as customer_name',
                'customer.mapping as customer_mapping', // Select the mapping from customer
                'inventory.tagging as tagging'
            )
            ->where('assets.approval_status', 'Approved') // Filter based on status 'Approved'
            ->get();

        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        // Retrieve all customers, no filtering needed
        $customers = Customer::all();

        // Retrieve all merks
        $merks = Merk::all();

        // Retrieve all inventories that have not been used in assets
        $usedAssetTaggings = DB::table('assets')->pluck('asset_tagging')->toArray();
        $inventories = Inventory::whereNotIn('id', $usedAssetTaggings)->get();

        // Determine availability of asset taggings and names
        $assetTaggingAvailable = $inventories->isNotEmpty();
        $namesAvailable = $customers->isNotEmpty();

        return view('assets.create', compact('merks', 'customers', 'inventories', 'assetTaggingAvailable', 'namesAvailable'));
    }



    public function edit($id)
    {
        $asset = DB::table('assets')
            ->join('merk', 'assets.merk', '=', 'merk.id')
            ->join('customer', 'assets.nama', '=', 'customer.id')
            ->select('assets.*', 'merk.name as merk_name', 'customer.name as customer_name')
            ->where('assets.id', $id)
            ->first();

        $merks = Merk::all();
        $customers = Customer::all();
        $inventories = Inventory::all();

        return view('assets.edit', compact('asset', 'merks', 'customers', 'inventories'));
    }

    public function pindah($id)
    {
        $asset = DB::table('assets')
            ->join('merk', 'assets.merk', '=', 'merk.id')
            ->join('customer', 'assets.nama', '=', 'customer.id')
            ->select('assets.*', 'merk.name as merk_name', 'customer.name as customer_name')
            ->where('assets.id', $id)
            ->first();

        $merks = Merk::all();
        $customers = Customer::all();
        $inventories = Inventory::all();

        return view('assets.pindahtangan', compact('asset', 'merks', 'customers', 'inventories'));
    }

    public function pindahUpdate(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'nama' => 'required|exists:customer,id',
            'lokasi' => 'required|string',
            'documentation' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Find the asset
        $asset = Assets::findOrFail($id);
        $customer = Customer::find($request->input('nama'));

        $assetData = [
            'nama' => $request->input('nama'),
            'mapping' => $customer->mapping,
            'lokasi' => $request->input('lokasi'),
        ];

        // Handle documentation file
        if ($request->hasFile('documentation')) {
            // Delete old documentation file if exists
            if ($asset->documentation && \Storage::exists($asset->documentation)) {
                \Storage::delete($asset->documentation);
            }

            $file = $request->file('documentation');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/uploads/documentation', $filename);
            $assetData['documentation'] = str_replace('public/', '', $filePath); // Save relative path
        }

        // Update the asset
        $asset->update($assetData);

        return redirect()->route('assets.index')->with('success', 'Asset transferred successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_tagging' => 'required|exists:inventory,id',
            'nama' => 'required|exists:customer,id',
            'status' => 'required|string',
            'o365' => 'required|string',
            'kondisi' => 'required|in:Good,Exception,Bad',
            'approval_status' => 'required|string',// Ensure valid status
            'documentation' => 'nullable|image|max:2048', // Updated to nullable
        ]);

        $inventory = Inventory::find($request->input('asset_tagging'));
        $customer = Customer::find($request->input('nama'));

        $assetData = [
            'asset_tagging' => $request->input('asset_tagging'),
            'jenis_aset' => $inventory->asets,
            'merk' => $inventory->merk,
            'type' => $inventory->type,
            'serial_number' => $inventory->seri,
            'nama' => $request->input('nama'),
            'mapping' => $customer->mapping,
            'o365' => $request->input('o365'),
            'lokasi' => $request->input('lokasi', ''),
            'status' => $request->input('status'),
            'kondisi' => $request->input('kondisi', ''),
            'approval_status' => $request->input('approval_status', ''), // Use input value
        ];

        if ($request->hasFile('documentation')) {
            $file = $request->file('documentation');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/documents', $filename);
            $assetData['documentation'] = 'documents/' . $filename;
        }

        Assets::create($assetData);

        return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_tagging' => 'required|exists:inventory,id',
            'nama' => 'required|exists:customer,id',
            'status' => 'required|string',
            'o365' => 'required|string',
            'kondisi' => 'required|in:Good,Exception,Bad',
            'approval_status' => 'nullable|string|in:Pending,Approved', // Ensure valid status
            'documentation' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Updated to nullable
        ]);

        $asset = Assets::findOrFail($id);
        $inventory = Inventory::find($request->input('asset_tagging'));
        $customer = Customer::find($request->input('nama'));

        $assetData = [
            'asset_tagging' => $request->input('asset_tagging'),
            'jenis_aset' => $inventory->asets,
            'merk' => $inventory->merk,
            'type' => $inventory->type,
            'serial_number' => $inventory->seri,
            'nama' => $request->input('nama'),
            'mapping' => $customer->mapping,
            'o365' => $request->input('o365'),
            'lokasi' => $request->input('lokasi', ''),
            'status' => $request->input('status'),
            'kondisi' => $request->input('kondisi', ''),
            'approval_status' => $request->input('approval_status', ''), // Use input value
        ];

        // Check if documentation file is uploaded
        if ($request->hasFile('documentation')) {
            // Delete old documentation file if exists
            if ($asset->documentation && \Storage::exists($asset->documentation)) {
                \Storage::delete($asset->documentation);
            }

            $file = $request->file('documentation');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/uploads/documentation', $filename);
            $assetData['documentation'] = str_replace('public/', '', $filePath); // Save relative path
        } else {
            // Keep the old file if no new file is uploaded
            $assetData['documentation'] = $asset->documentation;
        }

        $asset->update($assetData);

        return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
    }

    public function destroy($id)
    {
        $asset = Assets::findOrFail($id);
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Asset Returned successfully.');
    }


    public function show($id)
    {
        $asset = DB::table('assets')
            ->join('merk', 'assets.merk', '=', 'merk.id')
            ->join('customer', 'assets.nama', '=', 'customer.id')
            ->join('inventory', 'assets.asset_tagging', '=', 'inventory.id')
            ->select(
                'assets.*',
                'merk.name as merk_name',
                'customer.name as customer_name',
                'customer.mapping as customer_mapping',
                'inventory.tagging as tagging'
            )
            ->where('assets.id', $id)
            ->first();

        if (!$asset) {
            abort(404);
        }

        return view('assets.show', compact('asset'));
    }

    public function history()
    {
        $history = DB::table('asset_history')
            ->join('inventory', 'asset_history.asset_tagging_old', '=', 'inventory.id')
            ->join('merk', 'asset_history.merk_old', '=', 'merk.id')
            ->join('customer as old_customer', 'asset_history.nama_old', '=', 'old_customer.id')
            ->leftJoin('customer as new_customer', 'asset_history.nama_new', '=', 'new_customer.id') // Optional for update action
            ->select(
                'inventory.tagging as asset_tagging',
                'merk.name as merk',
                'asset_history.jenis_aset_old',
                'old_customer.name as nama_old',
                'new_customer.name as nama_new',
                'asset_history.changed_at',
                'asset_history.action'
            )
            ->whereIn('asset_history.action', ['CREATE', 'UPDATE', 'DELETE'])
            ->orderBy('asset_history.changed_at', 'DESC')
            ->get()
            ->groupBy('asset_tagging')
            ->map(function ($items) {
                return $items->unique('changed_at')->sortBy('changed_at');
            });

        return view('assets.history', compact('history'));
    }


}





