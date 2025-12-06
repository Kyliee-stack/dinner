<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Broadcast;

// =========================================================================================
// FIX UNTUK ERROR 'Route [login] not defined.'
// Middleware 'auth' secara default mencoba me-redirect ke route bernama 'login' saat gagal autentikasi.
// Kita arahkan route 'login' ini ke form login Admin yang sudah ada.
// =========================================================================================
Route::get('/login', function () {
    // Arahkan ke form login Admin
    return redirect()->route('admin.login.form');
})->name('login');


// ====================== MENU (FRONT END) ======================
// URL: /
Route::get('/', [MenuController::class, 'index'])->name('menu.index');

// ====================== CART & CHECKOUT (FRONT END) ======================
Route::prefix('cart')->group(function () {
    // URL: /cart/add (POST) - Untuk menambah item ke keranjang
    Route::post('/add', [MenuController::class, 'add'])->name('menu.add');

    // URL: /cart (GET) - Halaman utama keranjang
    Route::get('/', [MenuController::class, 'cart'])->name('cart.index');

    // URL: /cart/update (POST) - Untuk mengubah kuantitas item
    Route::post('/update', [MenuController::class, 'updateCart'])->name('menu.updateCart');

    // URL: /cart/remove (POST) - Untuk menghapus item
    Route::post('/remove', [MenuController::class, 'removeCart'])->name('menu.removeCart');

    // URL: /cart/checkout (GET) - Halaman isi data pembeli
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.page');
    
    // URL: /cart/checkout (POST) - Proses penyimpanan pesanan
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout');
});

// ====================== ORDER STATUS (FRONT END) ======================
// URL: /order/waiting/{id}
Route::get('/order/waiting/{id}', [OrderController::class, 'waiting'])->name('order.waiting');

// URL: /order-status/{id}
Route::get('/order-status/{id}', [OrderController::class, 'checkStatus'])->name('order.checkStatus');

// URL: /order/success/{id}
Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('order.success');


// ====================== ADMIN LOGIN ======================
// Route khusus untuk form login admin (Harus di luar middleware 'is.admin')
Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login.form');

// Route untuk memproses login admin
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('admin.login');


// ====================== ADMIN PANEL (DILINDUNGI) ======================
// Melindungi seluruh area admin dengan otentikasi (auth) DAN otorisasi (is.admin)
Route::middleware(['auth', 'is.admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 1. Manajemen Menu (CRUD Lengkap)
    Route::resource('menus', MenuController::class)->names([
        'index' => 'admin.menus.index',
        'create' => 'admin.menus.create',
        'store' => 'admin.menus.store',
        'show' => 'admin.menus.show',
        'edit' => 'admin.menus.edit',
        'update' => 'admin.menus.update',
        'destroy' => 'admin.menus.destroy',
    ]);

    // 2. Manajemen Pesanan (Daftar & Detail)
    // Hanya menggunakan index (daftar) dan show (detail)
    Route::resource('orders', OrderController::class)->only(['index', 'show'])->names([
        'index' => 'admin.orders.index',
        'show' => 'admin.orders.show',
    ]);
    
    // Route khusus untuk update status pesanan (PUT)
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // 3. Manajemen Stok/Inventaris (CRUD)
    Route::resource('inventories', InventoryController::class)->names([
        'index' => 'admin.inventories.index',
        'create' => 'admin.inventories.create',
        'store' => 'admin.inventories.store',
        'edit' => 'admin.inventories.edit',
        'update' => 'admin.inventories.update',
        'destroy' => 'admin.inventories.destroy',
    ]);
});

Broadcast::channel('orders', function ($user) {
    // Asumsi: Admin memiliki kolom/method 'is_admin' atau 'isAdmin()'
    return $user && $user->is_admin; 
});