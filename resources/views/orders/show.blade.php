@extends('layouts.admin') {{-- Sesuaikan dengan layout utama admin Anda --}}

@section('content')
<div class="container-fluid py-4">

    <div class="card shadow-lg border-0 mb-5">
        
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0">#{{ $order->id_pesanan }} | Detail Pesanan</h4>
            
            @php
                $statusClass = [
                    'Menunggu Konfirmasi' => 'badge-warning text-dark',
                    'Diproses' => 'badge-info',
                    'Selesai' => 'badge-success',
                    'Dibatalkan' => 'badge-danger',
                ][$order->status] ?? 'badge-secondary';
            @endphp
            
            <span class="badge {{ $statusClass }} p-2 h5 mb-0 font-weight-bold">
                STATUS: {{ $order->status }}
            </span>
        </div>

        <div class="card-body p-4">
            <div class="row">
                
                <div class="col-md-5 border-right">
                    
                    <h5 class="text-secondary mb-3"><i class="fas fa-info-circle mr-2"></i> Ringkasan Pesanan</h5>
                    
                    <dl class="row mb-4">
                        <dt class="col-sm-4 text-muted">ID Pesanan:</dt>
                        <dd class="col-sm-8 font-weight-bold">#{{ $order->id_pesanan }}</dd>

                        <dt class="col-sm-4 text-muted">Waktu Masuk:</dt>
                        <dd class="col-sm-8">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                    </dl>
                    
                    <h5 class="text-secondary mb-3"><i class="fas fa-user-circle mr-2"></i> Data Pelanggan</h5>
                    <dl class="row">
                        <dt class="col-sm-4 text-muted">Nama:</dt>
                        <dd class="col-sm-8">{{ $order->nama_pelanggan ?? 'Anonim' }}</dd>

                        <dt class="col-sm-4 text-muted">Tipe:</dt>
                        <dd class="col-sm-8">
                             <span class="badge badge-primary p-1">{{ $order->tipe_pesanan }}</span>
                        </dd>
                    </dl>
                </div>
                
                <div class="col-md-7">
                    
                    <h5 class="text-primary mb-3"><i class="fas fa-list-alt mr-2"></i> Daftar Item Pesanan</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm border">
                            <thead class="bg-light">
                                <tr>
                                    <th>Menu</th>
                                    <th>Level</th>
                                    <th class="text-center">Qty</th>
                                    <th>Catatan</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $subtotal_sum = 0; @endphp
                                @foreach ($order->items as $item)
                                @php $subtotal_sum += $item->subtotal; @endphp
                                <tr>
                                    <td>{{ $item->menu->nama }}</td>
                                    <td>{{ $item->level ?? '-' }}</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td>{{ $item->catatan ?? '-' }}</td>
                                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-right p-3 mt-3 border rounded" style="background-color: #f7f7f7;">
                        <div class="d-flex justify-content-end align-items-center mb-1">
                            <h5 class="mb-0 mr-3 text-muted">TOTAL HARGA:</h5>
                            <h5 class="mb-0 font-weight-bold">Rp {{ number_format($subtotal_sum, 0, ',', '.') }}</h5>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <h3 class="mb-0 mr-3 text-danger">GRAND TOTAL:</h3>
                            <h3 class="mb-0 text-danger font-weight-bolder">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-light border-top d-flex align-items-center justify-content-end py-3">
            <h5 class="text-danger mb-0 mr-3">Ubah Status Pesanan:</h5>
            
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="form-inline">
                @csrf
                @method('PUT')
                
                <div class="form-group mr-3">
                    <select id="statusBaru" name="status" class="form-control" required>
                        <option value="Menunggu Konfirmasi" {{ $order->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Siap Ambil/Selesai" {{ $order->status == 'Siap Ambil/Selesai' ? 'selected' : '' }}>Siap Ambil/Selesai</option>
                        <option value="Dibatalkan" {{ $order->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-danger font-weight-bold">
                    <i class="fas fa-check-circle mr-1"></i> Selesaikan Aksi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection