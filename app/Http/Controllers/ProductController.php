<?php

namespace App\Http\Controllers;

use App\Models\Product; // Import the Product model
use App\Models\Supplier; // Import the Supplier model
use Illuminate\Http\Request;
class ProductController extends Controller
{

//     public function search(Request $request)
// {
//     $query = $request->input('query');

//     // Search products by name, barcode, or supplier name
//     $products = Product::with('supplier')
//         ->where('name', 'like', "%{$query}%")
//         ->orWhere('barcode', 'like', "%{$query}%")
//         ->orWhereHas('supplier', function ($q) use ($query) {
//             $q->where('name', 'like', "%{$query}%");
//         })
//         ->get();

//     return response()->json($products);
// }
public function lowStock()
{
    // Fetch products with low stock (quantity <= 10)
    $lowStockProducts = Product::where('quantity', '<=', 10)->paginate(10);

    return view('products.low-stock', compact('lowStockProducts'));
}

    public function index(Request $request)
    {
        $query = $request->input('query');
    
        // Fetch products with optional search query
        $products = Product::with('supplier')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('barcode', 'like', "%{$query}%")
                  ->orWhereHas('supplier', function ($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->paginate(10);
    
        return view('products.index', compact('products'));
    }


public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
public function create()
{
    $suppliers = Supplier::all();
    return view('products.create', compact('suppliers'));
}

public function edit(Product $product)
{
    $suppliers = Supplier::all();
    return view('products.edit', compact('product', 'suppliers'));
}




public function update(Request $request, Product $product)
{
    // Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'nullable|integer|min:0',
        'price' => 'required|numeric|min:0',
        'cost' => 'required|numeric|min:0', 
        'description' => 'nullable|string',
        'barcode' => 'nullable|string|unique:products,barcode,' . $product->id,
        'supplier_id' => 'required|exists:suppliers,id',
    ]);

    // Update the product
    $product->update($validated);

    // Redirect back with success message
    return redirect()->route('product.index')->with('success', 'Product updated successfully.');
}



public function destroy( Product $product  ){
    // $product->delete();
    // return redirect(route('product.index'))->with('success','deleted');
    $product->delete();
return redirect (route('product.index'))->with('success', 'Product deleted Succesffully');

}


public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'nullable|integer|min:0',
        'price' => 'required|numeric|min:0',
        'cost' => 'required|numeric|min:0', // Add validation for cost
        'description' => 'nullable|string',
        'barcode' => 'nullable|string|unique:products,barcode',
        'supplier_id' => 'required|exists:suppliers,id',
    ]);

    // Create the product
    Product::create($validated);

    // Redirect back with success message
    return redirect()->route('product.index')->with('success', 'Product created successfully.');
}
}
