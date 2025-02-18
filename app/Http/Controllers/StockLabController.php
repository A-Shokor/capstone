<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockLog; // Import the StockLog model

class StockLabController extends Controller
{




    // Show the stock logs
public function showLogs()
{
    // Fetch all stock logs with product details
    $logs = StockLog::with('product')->latest()->paginate(10);

    return view('stock-logs.index', compact('logs'));
}
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
            'reason' => 'nullable|required_if:action,decrement|in:damaged,expired,lost_or_stolen', // Updated reasons
        ]);

        // Find the product
        $product = Product::findOrFail($validated['product_id']);

        // Perform the action
        if ($validated['action'] === 'increment') {
            $product->increment('quantity', $validated['quantity']);
            $message = "Stock incremented successfully.";
        } elseif ($validated['action'] === 'decrement') {
            // Ensure the stock quantity does not go below zero
            if ($product->quantity < $validated['quantity']) {
                return redirect()->back()->withErrors(['error' => 'Not enough stock available.']);
            }

            $product->decrement('quantity', $validated['quantity']);
            $message = "Stock decremented successfully due to: {$validated['reason']}.";
        }

        // Log the stock update
        StockLog::create([
            'product_id' => $validated['product_id'],
            'action' => $validated['action'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'] ?? null, // Null for increments
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', $message);
    }
}