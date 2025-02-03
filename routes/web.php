<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');;



// Route::get('/product',[ProductController::class,'index'])->name('product.index');
// Route::get('/product/create',[ProductController::class,'create'])->name('product.create');
// Route::post('/product',[ProductController::class,'store'])->name('product.store');
// Route::get('/product/{product}/edit',[ProductController::class,'edit'])->name('product.edit');
// Route::put('/product/{product}/update',[ProductController::class,'update'])->name('product.update');
// Route::delete('/product/{product}/destroy',[ProductController::class,'destroy'])->name('product.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware('auth')->group(function () {
         //product Crud
    Route::get('/product',[ProductController::class,'index'])->name('product.index');
    Route::get('/product/create',[ProductController::class,'create'])->name('product.create');
    Route::post('/product',[ProductController::class,'store'])->name('product.store');
    Route::get('/product/{product}/edit',[ProductController::class,'edit'])->name('product.edit');
    Route::put('/product/{product}/update',[ProductController::class,'update'])->name('product.update');
    Route::delete('/product/{product}/destroy',[ProductController::class,'destroy'])->name('product.destroy');


    //profile 
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('auth')->group(function () {
    // Supplier CRUD routes
    Route::resource('suppliers', SupplierController::class);

    // Product CRUD routes
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
