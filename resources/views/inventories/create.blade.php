@extends('layouts.admin')

@section('title', 'Tambah Item Stok Baru')
@section('page_title', 'Tambah Item Stok Baru')

@section('content')

<div class="data-form">
    <h3>Data Bahan Baku</h3>

    <form action="{{ route('admin.inventories.store') }}" method="POST">
        @csrf

        {{-- 1. Nama Bahan --}}
        <div class="form-group">
            <label for="item_name">Nama Bahan Baku <span class="required">*</span></label>
            <input type="text" id="item_name" name="item_name" value="{{ old('item_name') }}" class="form-control" required placeholder="Contoh: Mie Kering, Cabai Rawit">
            @error('item_name') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        {{-- 2. Satuan --}}
        <div class="form-group">
            <label for="unit">Satuan (Unit) <span class="required">*</span></label>
            <input type="text" id="unit" name="unit" value="{{ old('unit') }}" class="form-control" required placeholder="Contoh: Kilogram, Gram, Pcs, Bungkus">
            @error('unit') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group-row">
            {{-- 3. Stok Awal --}}
            <div class="form-group">
                <label for="current_stock">Stok Awal Saat Ini <span class="required">*</span></label>
                <input type="number" step="0.01" id="current_stock" name="current_stock" value="{{ old('current_stock', 0) }}" class="form-control" required min="0">
                @error('current_stock') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            {{-- 4. Batas Minimal Stok --}}
            <div class="form-group">
                <label for="min_stock_level">Batas Minimal Stok (Peringatan) <span class="required">*</span></label>
                <input type="number" step="0.01" id="min_stock_level" name="min_stock_level" value="{{ old('min_stock_level', 0) }}" class="form-control" required min="0">
                <small class="help-text">Jika stok di bawah batas ini, sistem akan memberi peringatan KRITIS.</small>
                @error('min_stock_level') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Item Stok</button>
            <a href="{{ route('admin.inventories.index') }}" class="btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection


