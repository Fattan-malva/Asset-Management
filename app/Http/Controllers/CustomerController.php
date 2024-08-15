<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', compact('customers'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('customer.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string|max:50',
            'role' => 'required|string|max:50',
            'nrp' => 'required|string|max:50',
            'name' => 'required|string|max:50',
            'mapping' => 'nullable|string|max:50',
        ]);

        Customer::create([
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'role' => $request->input('role'),
            'nrp' => $request->input('nrp'),
            'name' => $request->input('name'),
            'mapping' => $request->input('mapping'),
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    // Display the specified resource
    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    // Show the form for editing the specified resource
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string|max:50',
            'role' => 'required|string|max:50',
            'name' => 'required|string|max:50',
            'mapping' => 'nullable|string|max:50',
        ]);

        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully.');
    }
}
