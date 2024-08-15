<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // Import the DB facade

class MappingController extends Controller
{
    public function mapping()
    {
        // Run the SQL query
        $data = DB::table('assets')
            ->select('lokasi', 'jenis_aset', DB::raw('COUNT(*) as jumlah_aset'))
            ->groupBy('lokasi', 'jenis_aset')
            ->orderBy('lokasi')
            ->orderBy('jenis_aset')
            ->get();

        // Pass the data to the view
        return view('inventorys.mapping', ['data' => $data]);
    }
}
