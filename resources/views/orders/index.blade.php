@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')
@section('page_title', 'Daftar Pesanan Pelanggan')

@section('content')

<div class="data-table">
    
    {{-- Pesan Sukses/Error --}}
    @if (session('success'))
        <div class="alert-success" style="margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    {{-- Filter Status Pesanan --}}
    <div class="status-filter">
        <label>Filter Status:</label>
        @foreach ($statuses as $status)
            <a href="{{ route('admin.orders.index', ['status' => $status]) }}" 
                class="btn-filter {{ $currentStatus === $status ? 'active' : '' }}"
            >
                {{ $status }}
            </a>
        @endforeach
        <a href="{{ route('admin.orders.index', ['status' => 'Semua']) }}" 
            class="btn-filter {{ $currentStatus === 'Semua' ? 'active' : '' }}"
        >
            Semua
        </a>
    </div>

    @if ($orders->isEmpty())
        <div class="alert-info">
            Tidak ada pesanan dengan status "{{ $currentStatus }}".
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Tipe</th>
                    <th>Total Bayar</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Waktu Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                {{-- Sorot baris jika status 'Menunggu Konfirmasi' --}}
                <tr class="{{ $order->status === 'Menunggu Konfirmasi' ? 'row-pending' : '' }}"> 
                    <td><strong>#{{ $order->order_number }}</strong></td>
                    <td>{{ $order->nama_pelanggan }}</td> {{-- Pastikan menggunakan nama_pelanggan --}}
                    <td>{{ $order->order_type }}</td>
                    <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    <td><span class="badge-payment">{{ $order->payment_method }}</span></td>
                    <td>
                        {{-- PERBAIKAN: Mengganti str_slug() dengan Illuminate\Support\Str::slug() --}}
                        <span class="status-badge {{ Illuminate\Support\Str::slug($order->status, '-') }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('H:i:s, d M Y') }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn-action detail" title="Lihat Detail">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- Pagination --}}
        <div class="pagination-links" style="margin-top: 20px;">
            {{ $orders->appends(['status' => $currentStatus])->links() }}
        </div>
    @endif
</div>

@endsection

<style>
/* CSS Tambahan untuk Halaman Daftar Pesanan */
.row-pending {
    background-color: #fff8e1; /* Latar belakang kuning muda untuk pesanan baru */
    border-left: 5px solid #ffc107; /* Border kuning tebal */
}
.status-filter {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}
.status-filter label {
    font-weight: 600;
    margin-right: 5px;
    color: var(--color-dark);
}
.btn-filter {
    padding: 8px 15px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.2s;
    border: 1px solid #ccc;
    color: #333;
    background-color: #f8f9fa;
}
.btn-filter:hover {
    background-color: #e2e6ea;
}
.btn-filter.active {
    background-color: var(--color-primary);
    color: white;
    border-color: var(--color-primary);
}
.status-badge {
    padding: 5px 10px;
    border-radius: 5px;
    color: white;
    font-size: 0.85em;
    font-weight: 700;
    display: inline-block;
}
/* Warna Badge Status - Pastikan ini cocok dengan hasil slug: contoh "menunggu-konfirmasi" */
.menunggu-konfirmasi { background-color: #ffc107; color: #333; } /* Kuning */
.dikonfirmasi { background-color: #17a2b8; } /* Biru Muda */
.diproses { background-color: #007bff; } /* Biru */
.siap-diambil { background-color: #28a745; } /* Hijau */
.selesai { background-color: #6c757d; } /* Abu-abu */
.dibatalkan { background-color: var(--color-primary); } /* Merah Gacoan */
.badge-payment {
    padding: 3px 8px;
    border-radius: 5px;
    background-color: #00bcd4;
    color: white;
    font-size: 0.8em;
}
</style>