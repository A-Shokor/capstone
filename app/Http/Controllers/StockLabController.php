<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class StockLabController extends Controller
{
    // Display the stock lab page
    public function index(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('query');

        // Fetch products with their suppliers
        $products = Product::with('supplier')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('barcode', 'like', "%{$query}%")
                  ->orWhereHas('supplier', function ($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->paginate(10); // Paginate results for better responsiveness

        return view('stock-lab.index', compact('products', 'query'));
    }

    // Update the quantity of a product
    public function updateQuantity(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'action' => 'required|in:increment,decrement',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|required_if:action,decrement|string', // Reason is required only for decrement
        ]);

        // Find the product
        $product = Product::findOrFail($validated['product_id']);

        if ($validated['action'] === 'increment') {
            // Increment the quantity
            $product->increment('quantity', $validated['quantity']);
        } elseif ($validated['action'] === 'decrement') {
            // Ensure the quantity does not go below zero
            if ($product->quantity < $validated['quantity']) {
                return redirect()->back()->withErrors(['quantity' => 'Cannot decrement more than the available quantity.']);
            }

            // Decrement the quantity
            $product->decrement('quantity', $validated['quantity']);
        }

        // Redirect back with success message
        return redirect()->back()->with('success', 'Product quantity updated successfully.');
    }
}