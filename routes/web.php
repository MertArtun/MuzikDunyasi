<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ana Sayfa
Route::get('/', function () {
    // Her ana kategoriden bir ürün al
    $categories = \App\Models\Category::whereNull('parent_id')->pluck('id');
    
    $featuredProducts = collect();
    
    // Her ana kategoriden bir ürün ekle
    foreach ($categories as $categoryId) {
        $product = Product::where('category_id', $categoryId)
            ->active()
            ->inStock()
            ->first();
            
        if ($product) {
            $featuredProducts->push($product);
        }
    }
    
    return view('welcome', compact('featuredProducts'));
})->name('home');

// Hakkımızda
Route::get('/about', function () {
    return view('about');
});

// İletişim
Route::get('/contact', function () {
    return view('contact');
});

// Ürünler
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Auth Rotaları
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

// Sepet
Route::prefix('cart')->group(function () {
    Route::get('/', function () {
        return view('cart.index');
    });
    
    Route::get('/add/{id}', function ($id) {
        // Sepete ürün ekle
        return redirect()->back()->with('success', 'Ürün sepete eklendi');
    });
});

// Kullanıcı Profili
Route::middleware(['auth', 'active.user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Sipariş
Route::middleware(['auth', 'active.user'])->prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/confirmation/{order}', [OrderController::class, 'confirmation'])->name('orders.confirmation');
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/{order}/receive', [OrderController::class, 'markAsReceived'])->name('orders.receive');
});

// Admin Rotaları
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Admin Ürün Yönetimi
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
        
        // Ürün resmi işlemleri
        Route::post('/images/primary', [AdminProductController::class, 'setPrimaryImage'])->name('admin.products.images.primary');
        Route::post('/images', [AdminProductController::class, 'storeImage'])->name('admin.products.images.store');
        Route::delete('/images/{image}', [AdminProductController::class, 'deleteImage'])->name('admin.products.images.delete');
    });
    
    // Admin Sipariş Yönetimi
    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::put('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update_status');
        Route::post('/{order}/approve', [AdminOrderController::class, 'approve'])->name('admin.orders.approve');
        Route::post('/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('admin.orders.cancel');
    });
    
    // Admin Kullanıcı Yönetimi
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::put('/{user}/status', [AdminUserController::class, 'updateStatus'])->name('admin.users.update_status');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });
});

// Bülten Aboneliği
Route::post('/newsletter/subscribe', function () {
    return redirect()->back()->with('success', 'Bülten aboneliğiniz başarıyla kaydedildi');
});

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addProduct'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

require __DIR__.'/auth.php';
