<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
//     public function search(Request $request)
// {
//     // Get the search query from the request
//     $query = $request->input('query');

//     // Search purchase orders by supplier name or status
//     $purchaseOrders = PurchaseOrder::with('supplier')
//         ->whereHas('supplier', function ($q) use ($query) {
//             $q->where('name', 'like', "%{$query}%");
//         })
//         ->orWhere('status', 'like', "%{$query}%")
//         ->get();

//     // Pass the results to the view
//     return view('purchase-orders.index', compact('purchaseOrders'));
// }
    /**
     * Display a listing of purchase orders.
     */
    public function index(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('query');

        // Fetch purchase orders with optional search query
        $purchaseOrders = PurchaseOrder::with('supplier')
            ->when($query, function ($q) use ($query) {
                $q->whereHas('supplier', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->orWhere('status', 'like', "%{$query}%");
            })
            ->paginate(10); // Paginate results for better responsiveness

        return view('purchase-orders.index', compact('purchaseOrders', 'query'));
    }

    /**
     * Show the form for creating a new purchase order.
     */
    public function create()
{
    // Fetch all suppliers for the dropdown
    $suppliers = Supplier::all();

    // Pass the data to the view
    return view('purchase-orders.create', compact('suppliers'));
}

    /**
     * Store a newly created purchase order in storage.
     */
    public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'status' => 'nullable|string|in:pending,confirmed',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow images up to 2MB
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('purchase-order-images', 'public'); // Store in the "storage/app/public" directory
        $validated['image'] = $imagePath; // Save the file path
    }

    // Create the purchase order
    $purchaseOrder = PurchaseOrder::create($validated);

    // Redirect back with success message
    return redirect()->route('purchase-orders.index')->with('success', 'Purchase order created successfully.');
}
    /**
     * Display the specified purchase order.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        // Eager load relationships to avoid N+1 query issues
        $purchaseOrder->load('items.product');
    
        // Fetch products that belong to the same supplier as the purchase order
        $products = Product::where('supplier_id', $purchaseOrder->supplier_id)->get();
    
        return view('purchase-orders.show', compact('purchaseOrder', 'products'));
    }
    /**
     * Add a product to the purchase order.
     */
    public function addProduct(Request $request, PurchaseOrder $purchaseOrder)
{
    // Validate the request
    $validated = $request->validate([
        'product_id' => [
            'required',
            'exists:products,id',
            function ($attribute, $value, $fail) use ($purchaseOrder) {
                $product = Product::find($value);
                if (!$product || $product->supplier_id !== $purchaseOrder->supplier_id) {
                    $fail('The selected product does not belong to the supplier of this purchase order.');
                }
            },
        ],
        'quantity' => 'required|integer|min:1',
    ]);

    // Ensure the product belongs to the same supplier as the purchase order
    $product = Product::findOrFail($validated['product_id']);
    if ($product->supplier_id !== $purchaseOrder->supplier_id) {
        return redirect()->back()->with('error', 'The selected product does not belong to the supplier of this purchase order.');
    }

    // Add the product to the purchase order
    $purchaseOrder->items()->create([
        'product_id' => $validated['product_id'],
        'ordered_quantity' => $validated['quantity'],
        'received_quantity' => 0,
    ]);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Product added to the purchase order successfully.');
}
    /**
     * Save changes to received quantities.
     */
    public function saveChanges(Request $request, PurchaseOrder $purchaseOrder)
    {
        // Validate the request
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:purchase_order_items,id',
            'items.*.received_quantity' => 'required|integer|min:0',
        ]);
    
        // Update each item's received quantity
        foreach ($validated['items'] as $itemData) {
            $item = PurchaseOrderItem::findOrFail($itemData['id']);
            $item->update([
                'received_quantity' => $itemData['received_quantity'],
            ]);
        }
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Changes saved successfully.');
    }
    /**
     * Mark the purchase order as "confirmed" and update product stock.
     */
    public function receive(PurchaseOrder $purchaseOrder)
    {
        // Use a database transaction to ensure atomicity
        DB::transaction(function () use ($purchaseOrder) {
            // Update the purchase order status to "confirmed"
            $purchaseOrder->update(['status' => 'confirmed']);

            // Update the stock quantity (quantity column) for each product
            foreach ($purchaseOrder->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->increment('quantity', $item->received_quantity);
                }
            }
        });

        return redirect()->route('purchase-orders.show', $purchaseOrder)->with('success', 'Purchase order received successfully.');
    }

    

  


    public function destroy(PurchaseOrder $purchaseOrder)
{
    // Delete the purchase order and its associated items
    $purchaseOrder->items()->delete(); // Delete related purchase order items
    $purchaseOrder->delete(); // Delete the purchase order itself

    // Redirect with success message
    return redirect()->route('purchase-orders.index')->with('success', 'Purchase order deleted successfully.');
}


    public function uploadImage(Request $request, PurchaseOrder $purchaseOrder)
{
    // Validate the input
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
    ]);

    // Store the image in the storage/app/public/po_images directory
    $path = $request->file('image')->store('po_images', 'public');

    // Create a new PurchaseOrderImage record
    $purchaseOrder->images()->create([
        'image' => $path,
    ]);

    return redirect()->back()->with('success', 'Image uploaded successfully.');
}

//Send an email to the supplier with the purchase order details.

public function sendOrderEmail(PurchaseOrder $purchaseOrder)
{
   // Ensure the supplier has an email address
   if (!$purchaseOrder->supplier || !$purchaseOrder->supplier->email) {
       return redirect()->back()->withErrors(['error' => 'Supplier email is missing.']);
   }

   // Prepare the email data
   $supplierEmail = $purchaseOrder->supplier->email;
   $subject = "New Purchase Order (#{$purchaseOrder->id})";
   $data = [
       'purchaseOrder' => $purchaseOrder,
   ];

   // Send the email
   Mail::send('emails.purchase-order', $data, function ($message) use ($supplierEmail, $subject) {
       $message->to($supplierEmail)
               ->subject($subject);
   });

   // Redirect back with success message
   return redirect()->back()->with('success', 'Order email sent successfully to the supplier.');
}
}