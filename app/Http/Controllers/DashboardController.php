<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     
     * Display the dashboard.
     */
    public function index()
    {
        // dd('DashboardController@index is being called');
        // Calculate total products
        $totalProducts = Product::count();

        // Calculate total suppliers
        $totalSuppliers = Supplier::count();

        // Calculate low stock products (e.g., quantity <= 10)
        $lowStockProducts = Product::where('quantity', '<=', 10)->count();

        // Pass data to the view
        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'totalSuppliers' => $totalSuppliers,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}