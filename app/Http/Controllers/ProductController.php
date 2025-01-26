<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
   
        $products = Product::all();
        return view('products.index',['products'=>$products]);
    }

    public function create () {

        return view('products.create');


    }
//         public function store( Request $request){
        
//              dd($request->name);
//     // $data = $request->validate([

//     //         'name' =>'required',
//     //         'quantity' =>'required|numeric',
//     //         'price' =>'required|decimal:2',
//     //         'discription'=> 'nullable',

//     // ]);
//     //         $newProduct = Product::create($data);
//     //         return redirect (route('product.index'));
//     //     }
    
// }

public function edit (Product $product){
return view ('products.edit',['product'=>$product]);
}




public function update(Product $product, Request $request) {

    $data = $request->validate([
        'name' => 'required',
        'quantity' => 'required|numeric',
        'price' => 'required|numeric',
        'discription' => 'nullable',
    ]);
     $product->update($data);

 return redirect(route('product.index'))->with('success','product updated successfuly');

    
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
        'name' => 'required',
        'quantity' => 'required|numeric',
        'price' => 'required|numeric',
        'discription' => 'nullable',
    ]);

    // Debugging: Check the validated data
    //dd($data);

    $newProduct = Product::create($data);

    // Redirect back to product index
    return redirect(route('product.index'));

}
}
