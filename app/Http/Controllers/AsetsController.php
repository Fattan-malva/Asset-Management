<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Assets;
use App\Models\Inventory;
use App\Models\Merk;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AsetsController extends Controller
{
    public function index()
    {
        $assets = DB::table('assets')
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
            ->get();

        return view('assets.index', compact('assets'));
    }
    public function indexmutasi(Request $request)
    {
        // Initialize the query builder
        $query = DB::table('assets')
            ->join('merk', 'assets.merk', '=', 'merk.id')
            ->join('customer', 'assets.nama', '=', 'customer.id')
            ->join('inventory', 'assets.asset_tagging', '=', 'inventory.id')
            ->select(
                'assets.*',
                'merk.name as merk_name',
                'customer.name as customer_name',
                'customer.mapping as customer_mapping', // Select the mapping from customer
                'inventory.tagging as tagging'
            )
            ->where('assets.approval_status', 'Approved'); // Filter based on status 'Mutasi'

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('inventory.tagging', 'like', "%$search%")
                    ->orWhere('assets.jenis_aset', 'like', "%$search%")
                    ->orWhere('merk.name', 'like', "%$search%")
                    ->orWhere('customer.name', 'like', "%$search%");
            });
        }

        // Execute the query and get the results
        $assets = $query->get();

        // Return the view with assets
        return view('assets.indexmutasi', compact('assets'));
    }
    public function indexreturn(Request $request)
    {
        // Initialize the query builder
        $query = DB::table('assets')
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
            ->where('assets.approval_status', 'Approved'); // Filter based on status 'Mutasi'

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('inventory.tagging', 'like', "%$search%")
                    ->orWhere('assets.jenis_aset', 'like', "%$search%")
                    ->orWhere('merk.name', 'like', "%$search%")
                    ->orWhere('customer.name', 'like', "%$search%");
            });
        }

        // Execute the query and get the results
        $assets = $query->get();

        // Return the view with assets
        return view('assets.indexreturn', compact('assets'));
    }




    public function create()
    {
        // Retrieve all customers, no filtering needed
        $customers = Customer::where('role', '!=', 'Admin')->get();

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
        // Mengambil data aset beserta merk dan pelanggan terkait
        $asset = DB::table('assets')
            ->join('merk', 'assets.merk', '=', 'merk.id')
            ->join('customer', 'assets.nama', '=', 'customer.id')
            ->select('assets.*', 'merk.name as merk_name', 'customer.name as customer_name')
            ->where('assets.id', $id)
            ->first();

        // Mengambil semua merk
        $merks = Merk::all();

        // Mengambil semua pelanggan dan memfilter yang sedang dipilih
        $customers = Customer::all()->filter(function ($customer) use ($asset) {
            return $customer->id != $asset->nama;
        });

        // Mengambil semua inventaris
        $inventories = Inventory::all();

        // Mengirim data ke view
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
        $customers = Customer::where('role', '!=', 'Admin')->get();
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

        // Determine the most recent approved customer
        $latestApprovedAsset = Assets::where('approval_status', 'Approved')
            ->orderBy('updated_at', 'desc')
            ->first();

        $previousCustomerName = null;
        if ($latestApprovedAsset) {
            $previousCustomerName = $latestApprovedAsset->nama; // Get the name of the last approved asset
        }

        // Prepare data for update
        $assetData = [
            'previous_customer_name' => $previousCustomerName, // Set to the latest approved customer name
            'nama' => $request->input('nama'),
            'mapping' => $customer->mapping,
            'lokasi' => $request->input('lokasi'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'approval_status' => $request->input('approval_status', ''),
            'aksi' => $request->input('aksi', ''),
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

        return redirect()->route('assets.index')->with('success', 'Asset has been successfully mutated, waiting for user approval.');
    }





   public function store(Request $request)
{
    $request->validate([
        'asset_tagging' => 'required|exists:inventory,id',
        'nama' => 'required|exists:customer,id',
        'status' => 'required|string',
        'o365' => 'required|string',
        'kondisi' => 'required|in:Good,Exception,Bad',
        'approval_status' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
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
        'approval_status' => $request->input('approval_status', ''),
        'aksi' => $request->input('aksi', ''),
        'previous_customer_name' => $request->input('nama', ''),
        'latitude' => $request->input('latitude'),
        'longitude' => $request->input('longitude'),
    ];

    if ($request->hasFile('documentation')) {
        $file = $request->file('documentation');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/documents', $filename);
        $assetData['documentation'] = 'documents/' . $filename;
    }

    Assets::create($assetData);

    return redirect()->route('assets.index')->with('success', 'Assets have been successfully handed over. Please wait for the user to agree');
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
            ->leftJoin('inventory', 'asset_history.asset_tagging_old', '=', 'inventory.id')
            ->leftJoin('merk', 'asset_history.merk_old', '=', 'merk.id')
            ->leftJoin('customer as old_customer', 'asset_history.nama_old', '=', 'old_customer.id')
            ->leftJoin('customer as new_customer', 'asset_history.nama_new', '=', 'new_customer.id')
            ->select(
                'asset_history.asset_id', // Include asset_id
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
                // Filter out unchanged updates
                $filteredItems = $items->filter(function ($item) {
                    return $item->action === 'CREATE' ||
                        ($item->action === 'UPDATE' && $item->nama_old !== $item->nama_new) ||
                        $item->action === 'DELETE';
                });

                // Group by changed_at to remove duplicates
                $uniqueItems = $filteredItems->groupBy('changed_at')->map(function ($itemsByTime) {
                    return $itemsByTime->unique(function ($item) {
                        return $item->asset_tagging . '-' . $item->action;
                    })->values();
                })->flatten()->sortBy('changed_at');

                return $uniqueItems;
            });


        return view('assets.history', compact('history'));
    }


    public function returnAsset($id)
    {
        // Fetch the asset details including related merk and customer
        $asset = DB::table('assets')
            ->join('merk', 'assets.merk', '=', 'merk.id')
            ->join('customer', 'assets.nama', '=', 'customer.id')
            ->select('assets.*', 'merk.name as merk_name', 'customer.name as customer_name')
            ->where('assets.id', $id)
            ->first();

        // If the asset is not found, abort with a 404 error
        if (!$asset) {
            abort(404);
        }

        // If the approval status is "Pending," show the return form
        $merks = Merk::all();
        $customers = Customer::all();
        $inventories = Inventory::all();

        return view('assets.return', compact('asset', 'merks', 'customers', 'inventories'));
    }


    public function returnUpdate(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'nama' => 'required|exists:customer,id',
            'lokasi' => 'required|string',
            'documentation' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Find the asset
        $asset = Assets::findOrFail($id);
        $customer = Customer::find($request->input('nama'));

        // Determine the most recent approved customer
        $latestApprovedAsset = Assets::where('approval_status', 'Approved')
            ->orderBy('updated_at', 'desc')
            ->first();

        $previousCustomerName = null;
        if ($latestApprovedAsset) {
            $previousCustomerName = $latestApprovedAsset->nama; // Get the name of the last approved asset
        }

        // Prepare data for update
        $assetData = [
            'previous_customer_name' => $previousCustomerName, // Set to the latest approved customer name
            'nama' => $request->input('nama'),
            'mapping' => $customer->mapping,
            'lokasi' => $request->input('lokasi'),
            'approval_status' => 'Pending', // Status set to "Pending"
            'aksi' => $request->input('aksi'),
        ];

        // Handle documentation file
        if ($request->hasFile('documentation')) {
            // Delete old documentation file if exists
            if ($asset->documentation && \Storage::exists($asset->documentation)) {
                \Storage::delete($asset->documentation);
            }

            $file = $request->file('documentation');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/documents', $filename);
            $assetData['documentation'] = str_replace('public/', '', $filePath); // Save relative path
        } else {
            // If no file uploaded, retain the existing documentation file if it exists
            $assetData['documentation'] = $asset->documentation;
        }

        // Update the asset
        $asset->update($assetData);

        // Redirect to the index page with a success message
        return redirect()->route('assets.index')->with('success', 'The asset return request has been successfully submitted and is awaiting approval.');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $assets = Assets::query()
                ->with('customer', 'merk') // Include relationships if needed
                ->select(['id', 'tagging', 'customer_name', 'jenis_aset', 'merk_name', 'lokasi', 'status', 'approval_status']);

            return DataTables::of($assets)
                ->addColumn('actions', function ($asset) {
                    return view('partials.datatables-actions', compact('asset'));
                })
                ->make(true);
        }
    }


    public function reject($id)
    {

        $asset = Assets::findOrFail($id);


        switch ($asset->aksi) {
            case 'Handover':
                $asset->update(['approval_status' => 'Rejected']);
                break;

            case 'Mutasi':
                $asset->update(['approval_status' => 'Rejected']);
                break;

            case 'Return':
                $asset->update(['approval_status' => 'Rejected']);
                break;

            default:

                return redirect()->back()->with('error', 'Unexpected action type.');
        }


        return redirect()->back()->with('status', 'Asset has been rejected.');
    }

    public function rollbackMutasi($id)
    {
        // Find the asset
        $asset = Assets::findOrFail($id);

        // Check if there is a previous customer name to roll back to
        if (!$asset->previous_customer_name) {
            return redirect()->route('assets.index')->with('error', 'No previous customer name available for rollback.');
        }

        // Rollback to the previous customer name
        $asset->update([
            'nama' => $asset->previous_customer_name,
            'previous_customer_name' => null, // Clear the previous customer name
            'approval_status' => 'Approved', // Set to Pending or another status as needed
            'aksi' => 'Rollback' // Update the action or keep it as needed
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset name rolled back successfully.');
    }
    public function track($id)
    {
        $asset = Assets::findOrFail($id);

        return view('assets.track', compact('asset'));
    }

}





