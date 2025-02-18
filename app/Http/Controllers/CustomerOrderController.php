<?php

namespace App\Http\Controllers;

use App\Models\Customer; 
use App\Models\CustomerOrder;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function updateStatus(Request $request, CustomerOrder $customerOrder)
{
    $validated = $request->validate([
        'status' => 'required|string|in:preparing,ready,scheduled,delivering,delivered,received,canceled',
    ]);

    $customerOrder->update($validated);

    return redirect()->back()->with('success', 'Status updated successfully.');
}
    public function show(CustomerOrder $customerOrder)
{
    $customerOrder->load('customer', 'items.product');
    $products = \App\Models\Product::all(); // Fetch all products

    return view('customer-orders.show', compact('customerOrder', 'products'));
}
public function index()
{
    // Fetch active orders (excluding "received" and "canceled" statuses)
    $customerOrders = CustomerOrder::whereNotIn('status', ['received', 'canceled'])->get();

    // Pass the data to the view
    return view('customer-orders.index', compact('customerOrders'));
}
// Order History Page (Received Orders)
public function history()
{
    // Fetch all orders with "received" or "canceled" status
    $archivedOrders = CustomerOrder::whereIn('status', ['received', 'canceled'])->get();

    // Pass the data to the view
    return view('customer-orders.history', compact('archivedOrders'));
}
    public function create()
    {
        $customers = Customer::all(); // Fetch all customers
        $products = Product::all();   // Fetch all products
        return view('customer-orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'nullable|string',
            'products' => 'required|array',
            'quantities' => 'required|array',
        ]);
    
        // Fetch the customer's name
        $customer = \App\Models\Customer::findOrFail($validated['customer_id']);
    
        // Create the customer order
        $customerOrder = CustomerOrder::create([
            'customer_id' => $validated['customer_id'],
            'customer_name' => $customer->name, // Add the customer's name
            'status' => $validated['status'] ?? 'preparing',
        ]);
    
        // Attach products to the order
            foreach ($request->input('products') as $index => $productId) {
                if ($productId && isset($validated['quantities'][$index])) {
                     $customerOrder->items()->create([
                    'product_id' => $productId,
                     'quantity' => $validated['quantities'][$index],
        ]);
    }
}
    
        return redirect()->route('customer-orders.index')->with('success', 'Customer Order created successfully.');
    }

    public function edit(CustomerOrder $customerOrder)
    {
        $customers = Customer::all(); // Fetch all customers
        $products = Product::all();   // Fetch all products
        return view('customer-orders.edit', compact('customerOrder', 'customers', 'products'));
    }

    public function update(Request $request, CustomerOrder $customerOrder)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'nullable|string',
            'products' => 'required|array',
            'quantities' => 'required|array',
        ]);

        // Update the customer order
        $customerOrder->update([
            'customer_id' => $validated['customer_id'],
            'status' => $validated['status'] ?? 'preparing',
        ]);

        // Sync products with the order
        $customerOrder->items()->delete(); // Clear existing items
        foreach ($request->input('products') as $index => $productId) {
            if ($productId && isset($validated['quantities'][$index])) {
                $customerOrder->items()->create([
                    'product_id' => $productId,
                    'quantity' => $validated['quantities'][$index],
                ]);
            }
        }

        return redirect()->route('customer-orders.index')->with('success', 'Customer Order updated successfully.');
    }



    public function cancel(CustomerOrder $customerOrder)
{
    // Ensure the order is not already canceled or received
    if (in_array($customerOrder->status, ['canceled', 'received'])) {
        return redirect()->back()->with('error', 'This order cannot be canceled.');
    }

    // Update the status to "canceled"
    $customerOrder->update(['status' => 'canceled']);

    return redirect()->route('customer-orders.index')->with('success', 'Order canceled successfully.');
}
}