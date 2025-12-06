@extends('layouts.app')

@section('content')
<style>
    /* Styling Dasar */
    body {
        background-color: #f8f8f8;
        font-family: 'Inter', sans-serif;
        /* Tambahkan padding bawah karena ada bottom bar fixed */
        padding-bottom: 100px; 
    }
    .cart-page {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 15px; /* Tambahkan padding agar tidak menempel di sisi layar */
    }
    .cart-header {
        display: flex;
        align-items: center;
        padding: 15px 0;
        font-size: 1.25rem;
        font-weight: bold;
        border-bottom: 1px solid #eee;
        margin-bottom: 20px;
    }
    .cart-header a {
        font-size: 1.5rem;
        margin-right: 15px;
        text-decoration: none; /* Pastikan link tetap seperti tombol */
        color: #333;
    }

    /* Daftar Item */
    .cart-item {
        display: flex;
        gap: 15px;
        background: white;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin-bottom: 15px;
        align-items: center;
    }
    .cart-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }
    .cart-info {
        flex-grow: 1;
    }
    .item-name {
        font-weight: bold;
        margin: 0 0 4px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1rem;
    }
    .edit-btn {
        color: #ff3366; 
        font-weight: normal;
        font-size: 0.8rem;
        cursor: pointer;
    }
    .item-level {
        color: #777;
        font-size: 0.9rem;
        margin: 0;
    }
    .price {
        font-weight: bold;
        color: #333;
        margin-top: 5px;
    }

    /* Aksi Kuantitas */
    .cart-actions {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 20px;
        overflow: hidden;
    }
    .qty-btn {
        background: none;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 1.1rem;
        color: #333;
        transition: background-color 0.2s;
    }
    .qty-btn:hover {
        background-color: #f0f0f0;
    }
    .qty-btn:disabled {
        color: #ccc;
        cursor: default;
    }
    .qty-value {
        padding: 0 10px;
        font-weight: bold;
    }
    .cart-actions form {
        display: contents; /* Penting untuk menjaga layout flex */
    }

    /* Rincian Pembayaran */
    .rincian-judul {
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 15px;
        color: #ff3366;
    }
    .harga-baris {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        font-size: 0.95rem;
    }
    .harga-baris.total {
        font-size: 1.1rem;
        font-weight: bold;
        color: #ff3366;
    }

    /* BOTTOM BAR */
    .cart-bottom-fixed {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #ff3366; 
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
        max-width: 600px;
        margin: 0 auto; 
    }
    
    /* Harga Total di Bottom Bar */
    .total-harga {
        color: white;
        font-size: 1rem;
        font-weight: 500;
    }
    
    /* Tombol Checkout yang lebih kecil */
    .checkout-button-small {
        display: inline-block;
        background-color: white;
        color: #ff3366;
        padding: 10px 20px; 
        border-radius: 10px;
        font-weight: bold;
        text-decoration: none;
        transition: background-color 0.2s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .checkout-button-small:hover {
        background-color: #eee;
    }

    /* Menyembunyikan elemen lama jika ada */
    .cart-bottom-full { display: none; } 
</style>

<div class="cart-page">


<div class="cart-container">
<h3>Item yang dipesan ({{ $cartSummary['item_count'] ?? 0 }})</h3>


@foreach($cart as $menuId => $item)
@php
$nama = $item['name'] ?? ($item['nama'] ?? 'Nama Menu Tidak Ditemukan');
$qty = $item['qty'] ?? 0;
$harga = $item['price'] ?? 0;
$initial = substr($nama, 0, 1);
@endphp


@if ($qty > 0)
<div class="cart-item">
<img src="https://placehold.co/60x60/d81e5b/ffffff?text={{ urlencode($initial) }}" alt="{{ $nama }}" class="cart-img">
<div class="cart-info">
<h4 class="item-name">{{ $nama }} <span class="edit-btn">Ubah</span></h4>
<p class="item-level">{{ $qty }}x LEVEL 0</p>
<div class="price">Rp{{ number_format($harga * $qty, 0, ',', '.') }}</div>
</div>


<div class="cart-actions">
<form action="{{ route('menu.updateCart') }}" method="POST">
@csrf
<input type="hidden" name="menu_id" value="{{ $menuId }}">
<input type="hidden" name="qty" value="{{ max(0, $qty - 1) }}">
<button type="submit" class="qty-btn" {{ $qty <= 1 ? 'disabled' : '' }}>－</button>
</form>


<span class="qty-value">{{ $qty }}</span>


<form action="{{ route('menu.updateCart') }}" method="POST">
@csrf
<input type="hidden" name="menu_id" value="{{ $menuId }}">
<input type="hidden" name="qty" value="{{ $qty + 1 }}">
<button type="submit" class="qty-btn">＋</button>
</form>
</div>
</div>
@endif
@endforeach


<div class="rincian-pembayaran-cart" style="margin-top: 30px; padding: 20px; background: white; border-radius: 12px;">
<h4 class="rincian-judul">Rincian Pembayaran</h4>
<div class="harga-baris">
<span>Subtotal ({{ array_sum(array_column($cart ?? [], 'qty')) ?? 0 }} menu)</span>
<span>Rp{{ number_format($cartSummary['subtotal'] ?? $cartSummary['total_pembayaran'] ?? 0, 0, ',', '.') }}</span>
</div>
<div class="harga-baris">
<span>Pembulatan</span>
<span>-Rp{{ number_format($cartSummary['pembulatan'] ?? 0, 0, ',', '.') }}</span>
</div>
<div class="harga-baris">
<span>Biaya lainnya</span>
<span>Rp{{ number_format($cartSummary['biaya_lainnya'] ?? 0, 0, ',', '.') }}</span>
</div>


<div class="harga-baris total" style="border-top: 2px solid #eee; padding-top: 15px; margin-top: 15px;">
<span>Total Pembayaran</span>
<span>Rp{{ number_format($cartSummary['total_pembayaran'] ?? 0, 0, ',', '.') }}</span>
</div>
</div>


</div>


<div class="cart-bottom-fixed">
<span class="total-harga">Total: Rp{{ number_format($cartSummary['total_pembayaran'] ?? 0, 0, ',', '.') }}</span>
<a href="{{ route('checkout.page') }}" class="checkout-button-small">Lanjut Pembayaran</a>
</div>
</div>


@endsection