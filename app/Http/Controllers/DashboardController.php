<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return $this->showSummary();
    }

    public function showSummary()
    {
        // Data for Pie Chart: Jenis Aset from 'inventory' table
        $assetData = DB::table('inventory')
            ->select('asets as jenis_aset', DB::raw('count(*) as total'))
            ->groupBy('asets')
            ->get();

        // Data for Pie Chart: Lokasi Mapping from 'assets' table
        $locationData = DB::table('assets')
            ->select('lokasi', DB::raw('count(*) as total'))
            ->groupBy('lokasi')
            ->get();

        // Summary Report Data
        $operationSummary = DB::table('assets as a')
            ->join('merk as m', 'a.merk', '=', 'm.id')
            ->select(
                'a.jenis_aset as asset_name',
                'm.name as merk_name',
                DB::raw('COUNT(*) as operation_count')
            )
            ->where('a.status', '=', 'Operation')
            ->groupBy('a.jenis_aset', 'm.name')
            ->get()
            ->mapWithKeys(function ($item) {
                $key = $item->asset_name . '|' . $item->merk_name;
                return [
                    $key => [
                        'operation_count' => $item->operation_count
                    ]
                ];
            })
            ->toArray();

        $conditionSummary = DB::table('inventory as i')
            ->join('merk as m', 'i.merk', '=', 'm.id')
            ->select(
                'i.asets as asset_name',
                'm.name as merk_name',
                DB::raw('SUM(CASE WHEN i.kondisi = "Good" THEN 1 ELSE 0 END) as good_count'),
                DB::raw('SUM(CASE WHEN i.kondisi = "Exception" THEN 1 ELSE 0 END) as exception_count'),
                DB::raw('SUM(CASE WHEN i.kondisi = "Bad" THEN 1 ELSE 0 END) as bad_count')
            )
            ->where('i.status', '=', 'Inventory')
            ->groupBy('i.asets', 'm.name')
            ->get()
            ->mapWithKeys(function ($item) {
                $key = $item->asset_name . '|' . $item->merk_name;
                return [
                    $key => [
                        'good_count' => $item->good_count,
                        'exception_count' => $item->exception_count,
                        'bad_count' => $item->bad_count
                    ]
                ];
            })
            ->toArray();

        $inventorySummary = DB::table('assets as a')
            ->leftJoin('merk as m', 'a.merk', '=', 'm.id')
            ->select(
                'a.jenis_aset as asset_name',
                'm.name as merk_name',
                'a.lokasi as location',
                DB::raw('SUM(CASE WHEN a.status = "Inventory" THEN 1 ELSE 0 END) as inventory_count')
            )
            ->groupBy('a.jenis_aset', 'm.name', 'a.lokasi')
            ->get()
            ->map(function ($item) use ($conditionSummary, $operationSummary) {
                $assetName = $item->asset_name;
                $merkName = $item->merk_name;
                $inventoryKey = $assetName . '|' . $merkName;
                $conditionCounts = $conditionSummary[$inventoryKey] ?? [
                    'good_count' => 0,
                    'exception_count' => 0,
                    'bad_count' => 0
                ];
                $operationCount = $operationSummary[$inventoryKey]['operation_count'] ?? 0;

                return [
                    'asset_name' => $assetName,
                    'merk_name' => $merkName,
                    'locations' => [
                        [
                            'location' => $item->location ?: "-",
                            'operation_count' => $operationCount,
                            'inventory_count' => $item->inventory_count ?: "-"
                        ]
                    ],
                    'total_quantity' => $operationCount + $item->inventory_count,
                    'inventory_GSI' => $conditionCounts['good_count'] + $conditionCounts['exception_count'] + $conditionCounts['bad_count'] - $item->inventory_count,
                    'good_count' => $conditionCounts['good_count'],
                    'exception_count' => $conditionCounts['exception_count'],
                    'bad_count' => $conditionCounts['bad_count']
                ];
            });

        // Additional query to get specific inventory data based on your provided query
        $inventoryData = DB::table('inventory')
            ->select(
                'tagging AS asset_tagging',
                'asets AS asset',
                DB::raw('(SELECT name FROM merk WHERE id = inventory.merk) AS merk_name'),
                'kondisi'
            )
            ->where('status', 'Inventory')
            ->get();

        // Operation Summary Data
        $operationSummaryData = DB::table('assets as a')
            ->join('inventory as i', 'a.asset_tagging', '=', 'i.id') // Join inventory table to get tagging
            ->join('merk as m', 'a.merk', '=', 'm.id')
            ->select(
                'a.lokasi',
                'a.jenis_aset',
                'm.name AS merk',
                DB::raw('GROUP_CONCAT(i.tagging ORDER BY i.tagging ASC SEPARATOR "<br>") AS asset_tagging'), // Group and concatenate asset_tagging with line break
                DB::raw('COUNT(a.id) AS total_assets') // Count total assets
            )
            ->groupBy('a.lokasi', 'a.jenis_aset', 'm.name')
            ->orderBy('a.lokasi')
            ->orderBy('a.jenis_aset')
            ->orderBy('m.name')
            ->get();


        return view('shared.dashboard', [
            'totalAssets' => DB::table('inventory')->count(),
            'distinctLocations' => DB::table('assets')->distinct()->count('lokasi'),
            'distinctAssetTypes' => DB::table('inventory')->distinct()->count('asets'),
            'assetData' => $assetData,
            'locationData' => $locationData,
            'summary' => $inventorySummary,
            'inventoryData' => $inventoryData, // Passing the additional data to the view
            'operationSummaryData' => $operationSummaryData // Passing the operation summary data to the view
        ]);
    }
}
