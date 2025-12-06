@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)
@section('page_title', 'Detail Pesanan: #' . $order->order_number)

@section('content')

<div class="order-detail-container">
    
    {{-- Pesan Sukses (Setelah Update Status) --}}
    @if (session('success'))
        <div class="alert-success" style="margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    <div class="detail-header">
        <h3>Informasi Dasar Pesanan</h3>
        <div class="status-action">
            <span class="status-badge badge-{{ strtolower($order->status) }}">Status Saat Ini: {{ $order->status }}</span>
        </div>
    </div>
    
    <div class="card-grid">
        <div class="card detail-card">
            <h4>Pelanggan & Tipe</h4>
            <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
            <p><strong>Tipe Pesanan:</strong> <span class="badge badge-{{ strtolower(str_replace('-', '', $order->order_type)) }}">{{ $order->order_type }}</span></p>
        </div>
        
        <div class="card detail-card">
            <h4>Waktu & ID</h4>
            <p><strong>ID Pesanan:</strong> #{{ $order->order_number }}</p>
            <p><strong>Waktu Masuk:</strong> {{ $order->created_at->format('d M Y, H:i:s') }}</p>
        </div>
    </div>
    
    <div class="item-list-section">
        <h3>Daftar Item Pesanan</h3>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Level</th>
                    <th>Harga Satuan</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->menu_name }}</td>
                    <td>{{ $item->menu && $item->menu->kategori == 'Mie' ? ($item->menu->level_pedas ?? '-') : '-' }}</td>
                    <td>Rp {{ number_format($item->price_at_order, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    <td>{{ $item->notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL HARGA</td>
                    <td colspan="2" style="font-weight: bold;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
                @if ($order->discount > 0)
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold; color: var(--color-primary);">DISKON</td>
                    <td colspan="2" style="font-weight: bold; color: var(--color-primary);">- Rp {{ number_format($order->discount, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold; font-size: 1.1em;">GRAND TOTAL</td>
                    <td colspan="2" style="font-weight: bold; font-size: 1.1em; color: var(--color-primary);">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    {{-- Form Update Status --}}
    <div class="update-status-section data-form">
        <h4>Ubah Status Pesanan</h4>
        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group" style="display: flex; gap: 15px; align-items: center;">
                <label for="status" style="width: 150px; font-weight: bold;">Status Baru:</label>
                <select id="status" name="status" class="form-control" required style="flex-grow: 1; max-width: 250px;">
                    @foreach($statuses as $statusOption)
                        <option value="{{ $statusOption }}" {{ $order->status == $statusOption ? 'selected' : '' }}>
                            {{ $statusOption }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary" style="padding: 10px 20px;"><i class="fas fa-sync"></i> Update</button>
            </div>
            @error('status') <p class="error-message">{{ $message }}</p> @enderror
        </form>
    </div>

    <div class="form-actions" style="margin-top: 30px;">
        <a href="{{ route('admin.orders.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan</a>
    </div>

</div>

@endsection