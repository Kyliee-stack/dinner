<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Carbon\Carbon; // Digunakan untuk tanggal dan waktu

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin dengan data ringkasan.
     */
    public function index()
{
    // 1. Pesanan menunggu konfirmasi
    $pendingOrdersCount = Order::where('status', 'Menunggu Konfirmasi')->count();

    // 2. Item stok kritis ✅ (SESUAI DATABASE KAMU)
    $criticalInventoryCount = Inventory::whereColumn('current_stock', '<', 'min_stock_level')->count();

    // 3. Total penjualan hari ini
    $today = Carbon::today();
    $totalSalesToday = Order::whereIn('status', [
        'Dikonfirmasi',
        'Diproses',
        'Siap Diambil',
        'Selesai'
    ])
    ->whereDate('created_at', $today)
    ->sum('total'); // ✅ pastikan kolom ini memang ada di tabel orders

    // ✅ 4. TOTAL PESANAN SELESAI (INI YANG SEBELUMNYA HILANG)
    $totalCompletedOrders = Order::where('status', 'Selesai')->count();

    // ✅ KIRIM SEMUA DATA KE VIEW
    return view('admin.dashboard', compact(
        'pendingOrdersCount',
        'criticalInventoryCount',
        'totalSalesToday',
        'totalCompletedOrders' // ✅ SEKARANG SUDAH ADA
    ));
}
}