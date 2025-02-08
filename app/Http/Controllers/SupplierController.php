<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
//     public function search(Request $request)
// {
//     // Get the search query from the request
//     $query = $request->input('query');

//     // Search suppliers by name
//     $suppliers = Supplier::where('name', 'like', "%{$query}%")->get();

//     // Pass the results to the view
//     return view('suppliers.index', compact('suppliers'));
// }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('query');

        // Fetch suppliers with optional search query
        $suppliers = Supplier::when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%");
        })
        ->paginate(10); // Paginate results for better responsiveness

        return view('suppliers.index', compact('suppliers', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|unique:suppliers,name', // Ensure the name is unique
            'email' => 'required|email|unique:suppliers,email', // Ensure the email is unique
            'phone' => 'required|string|max:20', // Validate phone number
        ]);
    
        // Create the supplier
        $supplier = Supplier::create($validated);
    
        // Redirect back with success message
        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        // Eager load the supplier's products
        $supplier->load('products');

        // Calculate low stock products (e.g., quantity <= 10)
        $lowStockProducts = $supplier->products()->where('quantity', '<=', 10)->get();

        return view('suppliers.show', compact('supplier', 'lowStockProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $supplier->update($data);

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
    }
}