<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Fetch total products
        $totalProducts = Product::count();
        // Fetch total suppliers
        $totalSuppliers = Supplier::count();
        // Fetch the count of low-stock products (quantity <= 10)
        $lowStockCount = Product::where('quantity', '<=', 10)->count();
        // Fetch recently added products (e.g., last 5 products)
        $recentProducts = Product::with('supplier') // Eager load the supplier relationship
            ->latest() // Order by creation date (newest first)
            ->take(5) // Limit to 5 products
            ->get();
        // Calculate total stock quantity
        $totalStockQuantity = Product::sum('quantity');

        // Log the data for debugging purposes
        Log::info('Dashboard Data:', [
            'totalProducts' => $totalProducts,
            'totalSuppliers' => $totalSuppliers,
            'lowStockCount' => $lowStockCount,
            'recentProducts' => $recentProducts->toArray(),
            'totalStockQuantity' => $totalStockQuantity,
        ]);

        // Pass data to the view
        return view('dashboard', compact(
            'totalProducts',
            'totalSuppliers',
            'lowStockCount',
            'recentProducts',
            'totalStockQuantity'
        ));
    }
}