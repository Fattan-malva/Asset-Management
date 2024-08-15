<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Assets;
use App\Models\Inventory;
use App\Models\Merk;
use App\Models\Customer;
use Illuminate\Http\Request;

class AssetUserController extends Controller
{
    public function indexuser()
    {
        // Retrieve user ID from session
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('shared.home')->with('error', 'User is not logged in.');
        }

        // Fetch approved assets related to the logged-in user and join related tables
        $assets = DB::table('assets')
            ->join('merk', 'assets.merk', '=', 'merk.id')
            ->join('customer', 'assets.nama', '=', 'customer.id')
            ->join('inventory', 'assets.asset_tagging', '=', 'inventory.id')
            ->select(
                'assets.*',
                'merk.name as merk_name',
                'customer.name as customer_name',
                'inventory.tagging as tagging'
            )
            ->where('assets.nama', $userId) // Filter by user ID
            ->where('assets.approval_status', 'Approved') // Only get approved assets
            ->get();

        // Fetch pending assets related to the logged-in user and join related tables
        $pendingAssets = DB::table('assets')
            ->join('merk', 'assets.merk', '=', 'merk.id')
            ->join('customer', 'assets.nama', '=', 'customer.id')
            ->join('inventory', 'assets.asset_tagging', '=', 'inventory.id')
            ->select(
                'assets.*',
                'merk.name as merk_name',
                'customer.name as customer_name',
                'inventory.tagging as tagging'
            )
            ->where('assets.nama', $userId) // Filter by user ID
            ->where('assets.approval_status', 'Pending') // Only get pending assets
            ->get();

        return view('assets.assetuser', compact('assets', 'pendingAssets'));
    }

    public function serahterima($id)
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

        return view('assets.serahterima', compact('asset', 'merks', 'customers', 'inventories'));
    }

    public function updateserahterima(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'asset_tagging' => 'required|exists:inventory,id',
            'nama' => 'required|exists:customer,id',
            'status' => 'required|string',
            'o365' => 'required|string',
            'kondisi' => 'required|in:Good,Exception,Bad',
            'lokasi' => 'nullable|string',
            'documentation' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Temukan asset berdasarkan ID
            $asset = Assets::findOrFail($id);
            $inventory = Inventory::findOrFail($validatedData['asset_tagging']);
            $customer = Customer::findOrFail($validatedData['nama']);

            // Siapkan data untuk diperbarui
            $assetData = [
                'asset_tagging' => $validatedData['asset_tagging'],
                'jenis_aset' => $inventory->asets,
                'merk' => $inventory->merk,
                'type' => $inventory->type,
                'serial_number' => $inventory->seri,
                'nama' => $validatedData['nama'],
                'mapping' => $customer->mapping,
                'o365' => $validatedData['o365'],
                'lokasi' => $validatedData['lokasi'] ?? '',
                'status' => $validatedData['status'],
                'kondisi' => $validatedData['kondisi'],
                'approval_status' => $request->input('approval_status', ''),
            ];

            // Menangani file dokumentasi jika ada
            if ($request->hasFile('documentation')) {
                // Hapus dokumentasi lama jika ada
                if ($asset->documentation && \Storage::exists('public/' . $asset->documentation)) {
                    \Storage::delete('public/' . $asset->documentation);
                }

                // Simpan file dokumentasi baru
                $file = $request->file('documentation');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('public/uploads/documentation', $filename);
                $assetData['documentation'] = 'uploads/documentation/' . $filename;
            }

            // Perbarui asset dengan data yang baru
            $asset->update($assetData);

            // Redirect dengan pesan sukses
            return redirect()->route('shared.homeUser')->with('success', 'Asset Approved successfully.');

        } catch (\Exception $e) {
            // Log error dan redirect dengan pesan error
            \Log::error('Failed to update asset:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Failed to approve asset. Please try again.');
        }
    }

    public function destroyasset($id)
    {
        $asset = Assets::findOrFail($id);
        $asset->delete();

        return redirect()->route('asset-user')->with('success', 'Asset has been returned successfully.');
    }
}
