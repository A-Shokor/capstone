<?php
use App\Http\Controllers\CustomerOrderItemController;
use App\Http\Controllers\CustomerOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockLabController;
// Home Route
Route::get('/', function () {
    return view('dashboard
');
})->name('home');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Low Stock Products Route
Route::get('/products/low-stock', [ProductController::class, 'lowStock'])->name('product.low-stock');

// Stock Lab Routes
Route::get('/stock-lab', [StockLabController::class, 'index'])->name('stock-lab.index');
Route::post('/stock-lab/update-quantity', [StockLabController::class, 'updateQuantity'])->name('stock-lab.update-quantity');
// Product Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index'); // List all products
    Route::get('/create', [ProductController::class, 'create'])->name('product.create'); // Show product creation form
    Route::post('/', [ProductController::class, 'store'])->name('product.store'); // Store a new product
    Route::get('/{product}', [ProductController::class, 'show'])->name('product.show'); // Show a specific product
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('product.edit'); // Show product edit form
    Route::put('/{product}', [ProductController::class, 'update'])->name('product.update'); // Update a product
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('product.destroy'); // Delete a product
    //Route::get('/low-stock', [ProductController::class, 'lowStock'])->name('product.low-stock'); // Show low-stock products
   // Route::get('/search', [ProductController::class, 'search'])->name('products.search');
});
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
// Supplier Routes
Route::prefix('suppliers')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('supplier.index'); // List all suppliers
    Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create'); // Show supplier creation form
    Route::post('/', [SupplierController::class, 'store'])->name('supplier.store'); // Store a new supplier
    Route::get('/{supplier}', [SupplierController::class, 'show'])->name('supplier.show'); // Show a specific supplier
    Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit'); // Show supplier edit form
    Route::put('/{supplier}', [SupplierController::class, 'update'])->name('supplier.update'); // Update a supplier
    Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy'); // Delete a supplier
    Route::get('/search', [SupplierController::class, 'search'])->name('suppliers.search');

});

// Purchase Order Routes
Route::prefix('purchase-orders')->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])->name('purchase-orders.index'); // List all purchase orders
    Route::get('/create', [PurchaseOrderController::class, 'create'])->name('purchase-orders.create'); // Show purchase order creation form
    Route::post('/', [PurchaseOrderController::class, 'store'])->name('purchase-orders.store'); // Store a new purchase order
    Route::get('/{purchaseOrder}', [PurchaseOrderController::class, 'show'])->name('purchase-orders.show'); // Show a specific purchase order
    Route::post('/{purchaseOrder}/add-product', [PurchaseOrderController::class, 'addProduct'])->name('purchase-orders.add-product'); // Add a product to a purchase order
    Route::post('/{purchaseOrder}/save-changes', [PurchaseOrderController::class, 'saveChanges'])->name('purchase-orders.save-changes');   
     Route::post('/{purchaseOrder}/receive', [PurchaseOrderController::class, 'receive'])->name('purchase-orders.receive'); // Mark purchase order as "confirmed"
    Route::delete('/{purchaseOrder}', [PurchaseOrderController::class, 'destroy'])->name('purchase-orders.destroy'); // Delete a purchase order
    Route::post('/{purchaseOrder}/upload-image', [PurchaseOrderController::class, 'uploadImage'])
    ->name('purchase-orders.upload-image');
    Route::get('/search', [PurchaseOrderController::class, 'search'])->name('purchase-orders.search');

});
Route::post('/purchase-orders/{purchaseOrder}/send-order-email', [PurchaseOrderController::class, 'sendOrderEmail'])
    ->name('purchase-orders.send-order-email');

//stock lab 
Route::get('/stock-lab', [StockLabController::class, 'index'])->name('stock-lab.index');
Route::post('/stock-lab/update-quantity', [StockLabController::class, 'updateQuantity'])->name('stock-lab.update-quantity');
Route::get('/stock-logs', [StockLabController::class, 'showLogs'])->name('stock-logs.index');


// Purchase Order Item Routes
Route::prefix('purchase-order-items')->group(function () {
    Route::delete('/{item}', [PurchaseOrderItemController::class, 'destroy'])->name('purchase-order-item.destroy'); // Delete a purchase order item
});



//CustomerOrders
// Update Quantity
Route::put('/customer-order-items/{item}', [CustomerOrderItemController::class, 'update'])->name('customer-order-items.update');

// Delete Item
Route::delete('/customer-order-items/{item}', [CustomerOrderItemController::class, 'destroy'])->name('customer-order-items.destroy');
Route::prefix('customer-orders')->group(function () {
    Route::get('/', [CustomerOrderController::class, 'index'])->name('customer-orders.index'); // List all orders
    Route::get('/create', [CustomerOrderController::class, 'create'])->name('customer-orders.create'); // Create a new order
    Route::post('/store', [CustomerOrderController::class, 'store'])->name('customer-orders.store'); // Store a new order
    Route::get('/{customerOrder}/edit', [CustomerOrderController::class, 'edit'])->name('customer-orders.edit'); // Edit an order
    Route::put('/{customerOrder}', [CustomerOrderController::class, 'update'])->name('customer-orders.update'); // Update an order
    Route::delete('/{customerOrder}', [CustomerOrderController::class, 'destroy'])->name('customer-orders.destroy'); // Delete an order
    Route::get('/{customerOrder}', [CustomerOrderController::class, 'show'])->name('customer-orders.show');
    Route::post('/customer-order-items', [CustomerOrderItemController::class, 'store'])->name('customer-order-items.store');
    Route::put('/customer-orders/{customerOrder}/update-status', [CustomerOrderController::class, 'updateStatus'])->name('customer-orders.update-status');
    Route::get('/customer-orders/history', [CustomerOrderController::class, 'history'])->name('customer-orders.history');
    
    
    // Order Items
    Route::post('/{customerOrder}/add-product', [CustomerOrderController::class, 'addProduct'])->name('customer-orders.add-product'); // Add a product to an order
    Route::delete('/{customerOrder}/remove-product/{customerOrderItem}', [CustomerOrderController::class, 'removeProduct'])->name('customer-orders.remove-product'); // Remove a product from an order
});
// Cancel an Order
Route::put('/customer-orders/{customerOrder}/cancel', [CustomerOrderController::class, 'cancel'])
    ->name('customer-orders.cancel');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Show profile edit form
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete user account
});

Route::middleware(['web'])->group(function () {
    // Route for saving changes to a purchase order
    Route::post('/purchase-orders/{purchaseOrder}/save-changes', [PurchaseOrderController::class, 'saveChanges'])
         ->name('purchase-orders.save-changes');

    // Other purchase order routes
    Route::resource('purchase-orders', PurchaseOrderController::class);
});
// Authentication Routes (if using Laravel Breeze or Jetstream)
require __DIR__ . '/auth.php';