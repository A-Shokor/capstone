<?php

namespace App\Http\Controllers;

use App\Models\Product; // Import the Product model
use App\Models\Supplier; // Import the Supplier model
use Illuminate\Http\Request;
class ProductController extends Controller
{



    public function index()
{
    $products = Product::paginate(10); // Paginate the products (10 per page)
    return view('products.index', compact('products'));
}

//     public function create () {

//         return view('products.create');


//     }


// public function edit (Product $product){


// return view ('products.edit',['product'=>$product]);

// } 
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
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'required|numeric|min:0',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'barcode' => 'nullable|string|max:255', // Validate barcode
        'supplier_name' => 'nullable|string|max:255', // Validate supplier name
        'supplier_id' => 'nullable|numeric', // Validate supplier ID
    ]);

    $product->update($data);

    return redirect(route('product.index'))->with('success', 'Product updated successfully');
}




public function destroy( Product $product  ){
    // $product->delete();
    // return redirect(route('product.index'))->with('success','deleted');
    $product->delete();
return redirect (route('product.index'))->with('success', 'Product deleted Succesffully');

}


public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'required|numeric|min:0',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'barcode' => 'nullable|string|max:255', // Validate barcode
        'supplier_name' => 'nullable|string|max:255', // Validate supplier name
        'supplier_id' => 'nullable|numeric', // Validate supplier ID
    ]);

    $newProduct = Product::create($data);

    return redirect(route('product.index'))->with('success', 'Product created successfully');
}
}
