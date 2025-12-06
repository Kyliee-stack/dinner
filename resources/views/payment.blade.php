@extends('layouts.app')

@section('content')
<div class="payment-page-wrapper">
    <div class="cart-header" style="background: white; color: black; border-bottom: 1px solid #ddd;">
        <span class="back-arrow">←</span>
        Pembayaran
    </div>

    <form method="POST" action="{{ route('payment.process') }}" class="pembayaran-form-container">
        @csrf
        
        {{-- Tipe Pemesanan (Sesuai Screenshot 3) --}}
        <div class="tipe-pemesanan">
            Tipe Pemesanan: Makan di tempat <span style="margin-left: 10px;">✅</span>
        </div>

        {{-- Informasi Pemesanan --}}
        <div class="info-pemesanan-group">
            <h4 style="margin-top: 0;">Informasi Pemesanan</h4>
            
            <label for="nama_lengkap">Nama Lengkap*</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" required placeholder="Atikah Sari">

            <label for="nomor_ponsel">Nomor Ponsel (untuk info promo)</label>
            <input type="tel" id="nomor_ponsel" name="nomor_ponsel" placeholder="0896-3798-8091">
            
            <label for="email">Kirim struk ke email</label>
            <input type="email" id="email" name="email" placeholder="Email">
            
            <label for="nomor_meja">Nomor Meja*</label>
            <input type="text" id="nomor_meja" name="nomor_meja" required placeholder="4">

            <div class="promo-section">
                Tambah Promo atau Voucher >
            </div>
        </div>

        {{-- Ringkasan Total dan Tombol Bayar --}}
        <div class="payment-summary-bar">
            <div class="harga-baris total" style="color: #333; font-size: 1.1em; border: none;">
                <span>Total Pembayaran</span>
                <span>Rp{{ number_format($total_pembayaran, 0, ',', '.') }}</span>
            </div>
            
            <button type="submit" class="checkout-action-btn" style="background: var(--color-primary);">Bayar</button>
        </div>
    </form>
</div>
@endsection