@extends('layouts.admin')

@section('title', 'Edit Stok: ' . $inventory->item_name)
@section('page_title', 'Edit Stok: ' . $inventory->item_name)

@section('content')

<div class="data-form">
    <h3>Perbarui Data & Jumlah Stok</h3>

    <form action="{{ route('admin.inventories.update', $inventory) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- 1. Nama Bahan --}}
        <div class="form-group">
            <label for="item_name">Nama Bahan Baku <span class="required">*</span></label>
            <input type="text" id="item_name" name="item_name" value="{{ old('item_name', $inventory->item_name) }}" class="form-control" required placeholder="Contoh: Mie Kering, Cabai Rawit">
            @error('item_name') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        {{-- 2. Satuan --}}
        <div class="form-group">
            <label for="unit">Satuan (Unit) <span class="required">*</span></label>
            <input type="text" id="unit" name="unit" value="{{ old('unit', $inventory->unit) }}" class="form-control" required placeholder="Contoh: Kilogram, Gram, Pcs, Bungkus">
            @error('unit') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group-row">
            {{-- 3. Stok Saat Ini --}}
            <div class="form-group">
                <label for="current_stock">Stok Saat Ini <span class="required">*</span></label>
                <input type="number" step="0.01" id="current_stock" name="current_stock" value="{{ old('current_stock', $inventory->current_stock) }}" class="form-control" required min="0">
                @error('current_stock') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            {{-- 4. Batas Minimal Stok --}}
            <div class="form-group">
                <label for="min_stock_level">Batas Minimal Stok (Peringatan) <span class="required">*</span></label>
                <input type="number" step="0.01" id="min_stock_level" name="min_stock_level" value="{{ old('min_stock_level', $inventory->min_stock_level) }}" class="form-control" required min="0">
                <small class="help-text">Jika stok di bawah batas ini, status item akan menjadi KRITIS.</small>
                @error('min_stock_level') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Tampilkan Status Kritis Saat Ini --}}
        @if ($inventory->is_critical)
            <div class="alert-warning" style="margin-bottom: 20px;">
                <i class="fas fa-exclamation-triangle"></i> Status saat ini: **KRITIS**. Stok berada di bawah batas minimal!
            </div>
        @endif


        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="fas fa-sync"></i> Perbarui Stok</button>
            <a href="{{ route('admin.inventories.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Stok</a>
        </div>
    </form>
</div>

@endsection