<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrderItem;
use Illuminate\Http\Request;

class CustomerOrderItemController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_order_id' => 'required|exists:customer_orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Create the new order item
        CustomerOrderItem::create($validated);

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function update(Request $request, CustomerOrderItem $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item->update($validated);

        return response()->json(['message' => 'Quantity updated successfully']);
    }

    public function destroy(CustomerOrderItem $item)
    {
        $item->delete();

        return response()->json(['message' => 'Item removed successfully']);
    }
}