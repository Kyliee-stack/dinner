@extends('layouts.app')

{{-- Area untuk Style CSS Internal --}}
@push('styles')
    <style>
        /* Reset dan Font Dasar */
        body {
            font-family: sans-serif;
            margin: 0;
            background-color: #f8f8f8;
            /* Tambahkan padding bawah untuk memberi ruang bagi floating bar */
            padding-bottom: 70px;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .navbar-title {
            font-weight: bold;
            font-size: 1.1em;
        }

        .navbar-icons .icon {
            margin-left: 15px;
            cursor: pointer;
        }

        /* Tabs Navigasi */
        .tab-navigation {
            display: flex;
            background-color: white;
            border-bottom: 1px solid #eee;
            overflow-x: auto;
            margin-bottom: 10px;
        }

        .tab-item {
            padding: 10px 15px;
            cursor: pointer;
            color: #555;
            white-space: nowrap;
        }

        .tab-item.active {
            color: #d81e5b;
            border-bottom: 3px solid #d81e5b;
            font-weight: bold;
        }

        /* Menu List (2 Kolom) */
        .menu-list-container {
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
            gap: 10px;
            justify-content: flex-start;
        }

        /* --- CARD MENU DENGAN EFEK HOVER (ZOOM) --- */
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: calc(50% - 10px);

            overflow: hidden;
            text-align: left;
            max-width: 250px;

            /* Transisi untuk efek zoom yang mulus */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative; /* Penting untuk z-index */
            z-index: 1; 
        }

        /* EFEK HOVER (ZOOM) */
        .card:hover {
            transform: scale(1.05); /* Zoom 5% */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2); /* Bayangan lebih gelap */
            cursor: pointer;
            z-index: 10; /* Menampilkan kartu di atas kartu lain */
        }

        .card-img {
            width: 100% !important;
            height: 140px !important;
            object-fit: cover !important;
            display: block;
        }

        .card-content {
            padding: 10px;
        }

        .menu-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .price {
            font-size: 13px;
            color: #333;
            margin-bottom: 10px;
        }

        /* Quantity Controls */
        .card-footer-control {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
        }

        .qty-btn {
            background: none;
            border: 1px solid #d81e5b;
            color: #d81e5b;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
            padding: 0;
            line-height: 1;
        }
        
        /* Tombol Plus harus memiliki latar belakang pink */
        .qty-btn.plus-btn {
            background-color: #d81e5b;
            color: white;
        }

        .qty-btn:disabled {
            border-color: #ccc;
            color: #ccc;
            cursor: not-allowed;
        }

        .qty-value {
            padding: 0 10px;
        }

        form {
            display: inline-block;
        }

        /* ======== FLOATING CART BAR (Mobile/Single Column View) ======== */
        .floating-cart-bar {
            position: fixed !important;
            bottom: 10px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;

            width: 95% !important;
            max-width: 420px !important;
            background-color: #ff4081 !important;
            color: white !important;
            padding: 10px 15px !important;

            border-radius: 12px !important;

            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;

            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            z-index: 1000 !important;
        }

        /* Detail Keranjang (Ikon + Harga) */
        .cart-details {
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
        }

        /* Container Ikon Keranjang */
        .cart-icon-container {
            position: relative;
            font-size: 20px;
            line-height: 1;
        }

        .cart-icon-container .cart-icon {
            color: #ff4081;

            background-color: white;
            padding: 6px 8px;
            border-radius: 50%;
        }

        /* Badge Angka Jumlah Item */
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -8px;

            background-color: white !important;
            color: #ff4081 !important;

            border-radius: 50%;
            padding: 3px 6px;
            font-size: 10px;
            font-weight: bold;
            line-height: 1;
            min-width: 18px;
            text-align: center;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Teks Harga */
        .total-label {
            font-size: 11px;
            margin-bottom: 2px;
        }

        .total-price {
            font-size: 16px;
            font-weight: bold;
        }

        /* Tombol Check Out */
        .checkout-button {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 14px;
            padding: 5px 10px;
            border-bottom: 2px solid white;
            text-transform: uppercase;
        }
    </style>
@endpush

@section('content')
    {{-- NAVBAR (Header Utama) --}}
    <div class="navbar">
        <span class="navbar-title">Barang Mantan</span>
        <div class="navbar-icons">
            {{-- Ganti dengan Ikon Asli Anda (misalnya Font Awesome) --}}
            <span class="icon">🔍</span> 
            <span class="icon">☰</span>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="kolom-kiri">


            <div class="menu-list-container">
                {{-- Loop untuk menampilkan setiap menu. Pastikan variabel $menus tersedia dari Controller --}}
                @foreach ($menus ?? [] as $menu)
                    <div class="card" data-menu-id="{{ $menu->id ?? 0 }}">

                        {{-- Menggunakan image_url dari database --}}
                        <img src="{{ asset('images/' . ($menu->image ?? 'default.jpg')) }}" alt="{{ $menu->nama ?? 'Menu Item' }}"
                            class="card-img" onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';">

                        <div class="card-content">
                            <h3 class="menu-name">{{ $menu->nama ?? 'Nama Menu' }}</h3>
                            <div class="price">Rp{{ number_format($menu->harga ?? 0, 0, ',', '.') }}</div>

                            <div class="card-footer-control">
                                @php
                                    // Mengambil Qty saat ini. Pastikan variabel $cart tersedia dari Controller
                                    $currentQty = $cart[$menu->id ?? 0]['qty'] ?? 0;
                                @endphp

                                {{-- Tombol Minus/Kurang --}}
                                <form action="{{ route('menu.updateCart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id ?? 0 }}">
                                    {{-- Mengurangi qty 1. min 0 --}}
                                    <input type="hidden" name="qty" value="{{ max(0, $currentQty - 1) }}"> 
                                    <button type="submit" class="qty-btn minus-btn"
                                        {{ $currentQty < 1 ? 'disabled' : '' }}>
                                        －
                                    </button>
                                </form>

                                <span class="qty-value">
                                    {{ $currentQty }}
                                </span>

                                {{-- Tombol Plus/Tambah --}}
                                <form action="{{ route('menu.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id ?? 0 }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="qty-btn plus-btn">
                                        ＋
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- BOTTOM BAR CHECKOUT (FLOATING BAR) --}}
    {{-- Pastikan variabel $cartSummary tersedia dari Controller (item_count dan total_pembayaran) --}}
    @if (isset($cartSummary) && ($cartSummary['item_count'] ?? 0) > 0)
        <div class="floating-cart-bar">
            <div class="cart-details">
                <div class="cart-icon-container">
                    <span class="cart-badge">{{ $cartSummary['item_count'] }}</span>
                    {{-- Ikon Keranjang dari Unicode --}}
                    <span class="cart-icon">&#128717;</span> 
                </div>

                <div class="cart-text">
                    <div class="total-label">Total</div>
                    <div class="total-price">Rp{{ number_format($cartSummary['total_pembayaran'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <a href="{{ route('cart.index') }}" class="checkout-button">
                CHECK OUT ({{ $cartSummary['item_count'] }})
            </a>
        </div>
    @endif
@endsection