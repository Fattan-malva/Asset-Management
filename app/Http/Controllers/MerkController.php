<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Merk;


class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $merkes = Merk::all();
        return view('merk.index', compact('merkes'));
    }
    public function create()
    {
        $merkes = Merk::all();
        return view('merk.create', compact('merkes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Merk::create([
            'name' => $request->name,
        ]);

        return redirect()->route('inventorys.create')->with('success', 'Merk created successfully.');
    }



}
