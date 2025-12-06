@extends('layouts.admin')

@section('title', 'Manajemen Stok')
@section('page_title', 'Daftar Bahan Baku & Stok')

@section('content')

<div class="data-table">
    
    {{-- Pesan Sukses/Error --}}
    @if (session('success'))
        <div class="alert-success" style="margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    @if ($criticalCount > 0)
        <div class="alert-warning" style="margin-bottom: 20px;">
            <i class="fas fa-exclamation-triangle"></i> Terdapat <strong>{{ $criticalCount }}</strong> item stok yang mencapai batas kritis! Harap segera lakukan pengadaan.
        </div>
    @endif

    <div class="table-actions">
        <a href="{{ route('admin.inventories.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Item Stok Baru
        </a>
    </div>

    @if ($inventories->isEmpty())
        <div class="alert-info">
            Belum ada item stok yang tercatat di inventaris.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Bahan</th>
                    <th>Satuan</th>
                    <th>Stok Saat Ini</th>
                    <th>Batas Minimal (Peringatan)</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $item)
                {{-- Baris disorot jika stok kritis --}}
                <tr class="{{ $item->is_critical ? 'row-critical' : '' }}"> 
                    <td>{{ $item->id }}</td>
                    <td><strong>{{ $item->item_name }}</strong></td>
                    <td>{{ $item->unit }}</td>
                    <td>
                        {{ number_format($item->current_stock, 2) }} {{ $item->unit }}
                    </td>
                    <td>
                        {{ number_format($item->min_stock_level, 2) }} {{ $item->unit }}
                    </td>
                    <td>
                        @if ($item->is_critical)
                            <span class="status-badge badge-alert">KRITIS</span>
                        @else
                            <span class="status-badge badge-normal">NORMAL</span>
                        @endif
                    </td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.inventories.edit', $item) }}" class="btn-action edit" title="Edit Stok">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.inventories.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item stok {{ $item->item_name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete" title="Hapus Stok">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- Pagination --}}
        <div class="pagination-links" style="margin-top: 20px;">
            {{ $inventories->links() }}
        </div>
    @endif
</div>

@endsection

{{-- Tambahan CSS untuk halaman ini --}}
<style>
.row-critical {
    background-color: #ffe0e0; /* Latar belakang merah muda muda untuk item kritis */
}
.badge-alert {
    background-color: var(--color-primary); /* Merah Gacoan */
}
.badge-normal {
    background-color: #28a745; /* Hijau */
}
.alert-warning {
    background-color: #fff3cd;
    color: #856404;
    padding: 15px;
    border-radius: 5px;
    border: 1px solid #ffeeba;
    font-weight: 600;
}
.alert-warning strong {
    color: var(--color-primary);
}
.alert-warning i {
    margin-right: 8px;
}
</style>

