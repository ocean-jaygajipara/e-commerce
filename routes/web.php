<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/product/{slug}', function ($slug) {
    return view('product-details', ['slug' => $slug]);
})->name('product.details');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

// Real Auth Routes
Route::get('/auth', function () {
    return redirect()->route('login');
})->name('auth');

Route::get('/auth/login', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

Route::get('/auth/register', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.register');
})->name('register');

Route::get('/auth/reset', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.reset');
})->name('password.request');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

// Real Order Routes
Route::post('/checkout/order', [\App\Http\Controllers\OrderController::class, 'placeOrder'])->name('order.place');
Route::post('/product/{id}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('product.review.store');
Route::post('/order/{id}/return', [\App\Http\Controllers\OrderController::class, 'returnOrder'])->name('order.return');
Route::get('/api/track-order', [\App\Http\Controllers\OrderController::class, 'getOrderStatus']);

Route::post('/api/user/address', function (\Illuminate\Http\Request $request) {
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }
    $request->validate([
        'fullname' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'city' => ['required', 'string', 'max:255'],
        'pincode' => ['required', 'string', 'max:10'],
    ]);
    
    auth()->user()->update([
        'fullname' => $request->fullname,
        'address' => $request->address,
        'city' => $request->city,
        'pincode' => $request->pincode,
    ]);
    
    return response()->json(['success' => true, 'message' => 'Address saved to database successfully!']);
});

Route::get('/api/products/stock', function () {
    return response()->json(\App\Models\Product::select('id', 'name', 'colors', 'stock')->get());
});

// Real Admin Routes
Route::get('/admin/login', [\App\Http\Controllers\AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');

Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::get('/admin/orders', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.orders');
Route::get('/admin/categories', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.categories');
Route::get('/admin/products', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.products');
Route::get('/admin/customers', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.customers');

Route::post('/admin/order/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateStatus'])->name('admin.order.status');
Route::post('/admin/category', [\App\Http\Controllers\AdminController::class, 'addCategory'])->name('admin.category.add');
Route::delete('/admin/category/{id}', [\App\Http\Controllers\AdminController::class, 'deleteCategory'])->name('admin.category.delete');
Route::post('/admin/product', [\App\Http\Controllers\AdminController::class, 'addProduct'])->name('admin.product.add');
Route::delete('/admin/product/{id}', [\App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('admin.product.delete');

// Real Dashboard Route (Protected)
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('auth');
    }
    return view('dashboard');
})->name('dashboard');

Route::get('/my-order', function () {
    if (!auth()->check()) {
        return redirect()->route('auth');
    }
    return view('dashboard', ['activeTab' => 'orders']);
})->name('my-orders');

Route::get('/my-profile', function () {
    if (!auth()->check()) {
        return redirect()->route('auth');
    }
    return view('dashboard', ['activeTab' => 'profile']);
})->name('my-profile');

Route::get('/my-wishlist', function () {
    if (!auth()->check()) {
        return redirect()->route('auth');
    }
    return view('dashboard', ['activeTab' => 'wishlist']);
})->name('my-wishlist');

Route::get('/saved-addresses', function () {
    if (!auth()->check()) {
        return redirect()->route('auth');
    }
    return view('dashboard', ['activeTab' => 'addresses']);
})->name('saved-addresses');

Route::get('/search', function () {
    return view('search');
})->name('search');

Route::get('/category/{slug}', function ($slug) {
    return view('category', ['slug' => $slug]);
})->name('category');

Route::get('/brand', function () {
    return view('brand');
})->name('brand');

Route::get('/offers', function () {
    return view('offers');
})->name('offers');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/blog/{slug}', function ($slug) {
    return view('blog-details', ['slug' => $slug]);
})->name('blog.details');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/legal/{tab?}', function ($tab = 'privacy') {
    return view('legal', ['tab' => $tab]);
})->name('legal');

Route::get('/track-order', function () {
    return view('track-order');
})->name('track.order');

// Custom 404 Fallback
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
