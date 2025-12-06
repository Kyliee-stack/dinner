@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Selamat Datang di Admin Panel')

@section('content')

<div class="dashboard-container">
    <div class="header-welcome">
        <h2>Halo, Admin</h2>
        <p>Anda berada di pusat kontrol untuk mengelola pesanan, menu, dan inventaris.</p>
    </div>

    {{-- Kartu Ringkasan --}}
    <div class="summary-cards">
        
        {{-- Pesanan Baru --}}
        <div class="card card-order-new">
            <div class="icon-wrap"><i class="fas fa-bell"></i></div>
            <div class="info">
                <p class="label">Pesanan Menunggu Konfirmasi</p>
                {{-- MENGGUNAKAN DATA NYATA DARI CONTROLLER --}}
                <h3 class="value">{{ $pendingOrdersCount }}</h3> 
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'Menunggu Konfirmasi']) }}" class="action-link">Lihat Pesanan Baru &rarr;</a>
        </div>
        
        {{-- Total Penjualan Hari Ini --}}
        <div class="card card-sales">
            <div class="icon-wrap"><i class="fas fa-coins"></i></div>
            <div class="info">
                <p class="label">Total Penjualan Hari Ini</p>
                {{-- MENGGUNAKAN DATA NYATA DARI CONTROLLER --}}
                <h3 class="value">Rp {{ number_format($totalSalesToday, 0, ',', '.') }}</h3> 
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'Selesai']) }}" class="action-link">Lihat Detail &rarr;</a>
        </div>

        {{-- Total Pesanan Selesai (Baru Ditambah) --}}
        <div class="card card-completed">
            <div class="icon-wrap"><i class="fas fa-clipboard-check"></i></div>
            <div class="info">
                <p class="label">Total Pesanan Selesai</p>
                {{-- MENGGUNAKAN DATA NYATA DARI CONTROLLER --}}
                <h3 class="value">{{ $totalCompletedOrders }}</h3> 
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'Selesai']) }}" class="action-link">Riwayat Pesanan &rarr;</a>
        </div>

        {{-- Stok Kritis --}}
        <div class="card card-inventory-critical">
            <div class="icon-wrap"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="info">
                <p class="label">Item Stok Kritis</p>
                {{-- MENGGUNAKAN DATA NYATA DARI CONTROLLER --}}
                <h3 class="value">{{ $criticalInventoryCount }}</h3> 
            </div>
            <a href="{{ route('admin.inventories.index', ['filter' => 'critical']) }}" class="action-link">Kelola Inventaris &rarr;</a>
        </div>
        
    </div>

    {{-- Peringatan Penting --}}
    <div class="important-info-box">
        <h4 style="margin-top: 0;"><i class="fas fa-clock"></i> Prioritas Utama</h4>
        <p>Segera periksa **Daftar Pesanan** dengan status **Menunggu Konfirmasi** untuk memproses pembayaran pelanggan dan mengubah status menjadi **Dikonfirmasi**.</p>
        <a href="{{ route('admin.orders.index', ['status' => 'Menunggu Konfirmasi']) }}" class="btn-primary" style="display: inline-block; margin-top: 10px;">
            <i class="fas fa-clipboard-list"></i> Lihat Pesanan Baru
        </a>
    </div>

</div>

@endsection

<style>
/* PENYESUAIAN TAMPILAN UNTUK MEMPERCANTIK */
:root {
    --color-primary: #e3342f; /* Merah Gacoan */
    --color-dark: #343a40;
}
.dashboard-container {
    padding: 20px;
}
.header-welcome {
    background-color: #ffffff; /* Ubah ke putih bersih */
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Tambah shadow ringan */
}
.header-welcome h2 {
    color: var(--color-primary); /* Ubah warna h2 ke merah utama */
    margin-top: 0;
    margin-bottom: 5px;
    font-size: 2.2rem;
    font-weight: 800;
}
.header-welcome p {
    color: #495057;
    font-size: 1.1rem;
}

.summary-cards {
    display: grid;
    /* Ubah agar bisa menampilkan 4 kartu secara bagus */
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
    gap: 20px;
    margin-bottom: 30px;
}
.card {
    background: #fff;
    padding: 25px; /* Sedikit lebih besar */
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}
.card:hover {
    transform: translateY(-5px); /* Efek melayang lebih terasa */
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}
.icon-wrap {
    font-size: 3rem; /* Ikon lebih besar */
    margin-bottom: 10px;
}
.card-order-new .icon-wrap { color: #ffc107; } /* Kuning Peringatan */
.card-sales .icon-wrap { color: #17a2b8; } /* Biru Muda/Info */
.card-inventory-critical .icon-wrap { color: var(--color-primary); } /* Merah Gacoan */
.card-completed .icon-wrap { color: #28a745; } /* Hijau Sukses (Kartu Baru) */

.info .label {
    font-size: 0.95rem;
    color: #6c757d;
    margin: 0;
    font-weight: 600;
}
.info .value {
    font-size: 2.5rem; /* Nilai lebih besar */
    font-weight: 900;
    margin: 5px 0 15px 0;
    color: var(--color-dark);
}
.action-link {
    color: #007bff;
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
}
.action-link:hover {
    color: var(--color-primary);
    text-decoration: underline;
}

.important-info-box {
    background-color: #fcebeb; /* Merah muda sangat muda */
    color: var(--color-dark);
    padding: 30px;
    border-radius: 15px;
    border: 2px solid var(--color-primary); /* Border lebih tebal */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}
.important-info-box h4 {
    color: var(--color-primary);
    font-size: 1.5rem;
}
.important-info-box p {
    font-size: 1.1rem;
    margin-bottom: 15px;
}
.btn-primary {
    background-color: var(--color-primary);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    text-decoration: none;
    transition: background-color 0.2s;
}
.btn-primary:hover {
    background-color: #c72c27;
}
</style>