<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Inventory;

class PrintController extends Controller
{
    public function handover(Request $request)
    {
        $tagNumber = $request->query('asset_tagging');

        \Log::info('Tag Number: ' . $tagNumber);

        $inventory = DB::table('inventory')
            ->where('tagging', $tagNumber)
            ->first();

        if (!$inventory) {
            return view('prints.handover')->with('error', 'Data not found in inventory');
        }

        $handover = DB::table('asset_history')
            ->join('customer', 'asset_history.nama_old', '=', 'customer.id')
            ->join('merk', 'asset_history.merk_old', '=', 'merk.id')
            ->where('asset_history.asset_tagging_new', $inventory->id)
            ->select(
                'asset_history.*',
                'customer.name as customer_name',
                'customer.nrp as customer_nrp',
                'customer.mapping as customer_mapping',
                'merk.name as merk_name'
            )
            ->first();

        \Log::info('Handover Data: ', (array) $handover);

        if (!$handover) {
            return view('prints.handover')->with('error', 'Data not found in asset history');
        }

        return view('prints.handover', ['handover' => $handover, 'inventory' => $inventory, 'tagging' => $inventory->tagging]);
    }

    public function mutation(Request $request)
    {
        $tagNumber = $request->query('asset_tagging');
    
        \Log::info('Tag Number: ' . $tagNumber);
    
        // Ambil data inventory berdasarkan tagging
        $inventory = DB::table('inventory')
            ->where('tagging', $tagNumber)
            ->first();
    
        if (!$inventory) {
            return view('prints.mutation')->with('error', 'Data not found in inventory');
        }
    
        // Ambil data mutation terbaru dari tabel asset_history dengan kondisi yang diinginkan
        $mutation = DB::table('asset_history')
            ->join('customer as old_customer', 'asset_history.nama_old', '=', 'old_customer.id')
            ->join('customer as new_customer', 'asset_history.nama_new', '=', 'new_customer.id')
            ->join('merk', 'asset_history.merk_new', '=', 'merk.id')
            ->where('asset_history.asset_tagging_new', $inventory->id)
            ->where('asset_history.action', 'UPDATE') 
            ->whereColumn('asset_history.nama_old', '!=', 'asset_history.nama_new') // Pastikan nama_old dan nama_new berbeda
            ->orderBy('asset_history.changed_at', 'DESC') // Urutkan berdasarkan yang terbaru
            ->select(
                'asset_history.*',
                'old_customer.name as old_customer_name',
                'old_customer.nrp as old_customer_nrp',
                'new_customer.name as new_customer_name',
                'new_customer.nrp as new_customer_nrp',
                'merk.name as merk_name'
            )
            ->first(); // Ambil hanya mutasi terbaru
    
        \Log::info('Mutation Data: ', (array) $mutation);
    
        if (!$mutation) {
            return view('prints.mutation')->with('error', 'Data not found in asset history');
        }
    
        // Kirim data ke view
        return view('prints.mutation', [
            'mutation' => $mutation,
            'inventory' => $inventory,
            'tagging' => $inventory->tagging,
            'isDifferent' => $mutation->old_customer_name !== $mutation->new_customer_name
        ]);
    }
    






    public function return(Request $request)
    {
        $tagNumber = $request->query('asset_tagging');

        \Log::info('Tag Number: ' . $tagNumber);

        $inventory = DB::table('inventory')
            ->where('tagging', $tagNumber)
            ->first();

        if (!$inventory) {
            return view('prints.return')->with('error', 'Data not found in inventory');
        }

        $return = DB::table('asset_history')
            ->join('customer', 'asset_history.nama_old', '=', 'customer.id')
            ->join('merk', 'asset_history.merk_old', '=', 'merk.id')
            ->where('asset_history.asset_tagging_old', $inventory->id)
            ->where('asset_history.action', 'DELETE')
            ->select(
                'asset_history.*',
                'customer.name as customer_name',
                'customer.nrp as customer_nrp',
                'customer.mapping as customer_mapping',
                'merk.name as merk_name'
            )
            ->first();

        \Log::info('Handover Data: ', (array) $return);

        if (!$return) {
            return view('prints.return')->with('error', 'Data not found in asset history');
        }

        return view('prints.return', ['return' => $return, 'inventory' => $inventory, 'tagging' => $inventory->tagging]);
    }
    public function print($id)
    {
        // Fetch inventory with merk name
        $inventory = DB::table('inventory')
            ->join('merk', 'inventory.merk', '=', 'merk.id')
            ->select('inventory.*', 'merk.name as merk_name')
            ->where('inventory.id', $id)
            ->first();

        if (!$inventory) {
            abort(404); // Handle not found case
        }

        // Generate the URL for asset detail
        $url = route('auth.detailQR', ['id' => $inventory->id]);

        // Generate the QR code that contains the URL
        $qrCode = QrCode::size(200)->generate($url);

        // Return the print view with QR code
        return view('prints.qr_code', compact('qrCode', 'inventory'));
    }
    // app/Http/Controllers/PrintController.php
    public function showAssetDetail($id)
    {
        // Fetch inventory with merk name
        $inventory = DB::table('inventory')
            ->join('merk', 'inventory.merk', '=', 'merk.id')
            ->select('inventory.*', 'merk.name as merk_name')
            ->where('inventory.id', $id)
            ->first();

        if (!$inventory) {
            abort(404); // Handle not found
        }

        // Return the view with asset details
        return view('auth.detailQR', compact('inventory'));
    }

}
