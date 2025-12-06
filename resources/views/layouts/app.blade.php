<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Penting untuk POST/Form --}}
    <title>Sistem Pemesanan barang mantan</title>

    {{-- Memuat File CSS yang Sudah Dibuat --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Ganti dengan path CSS Anda (misal: /css/app.css jika menggunakan Vite/Mix) --}}
    <link rel="stylesheet" href="{{ asset('css/pemesanan.css') }}">

    {{-- Tambahkan styling CSS yang sudah Anda perbaiki ke file pemesanan.css --}}

    @stack('styles') {{-- Ini yang akan membaca CSS dari menu.blade.php sekarang --}}
</head>

<body>

    {{-- Notifikasi: Untuk menampilkan pesan success/error dari Controller --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- KONTEN UTAMA DARI SETIAP HALAMAN AKAN DI SINI --}}
    <main>
        @yield('content')
    </main>

    {{-- KERANJANG MINI (BOTTOM BAR) akan dipanggil di halaman menu --}}
    {{-- Untuk layout utama, kita hanya akan memuat JS --}}

    @stack('scripts') {{-- Untuk JavaScript spesifik halaman --}}
</body>

</html>

<style>
    /* Styling dasar notifikasi agar pesan success/error terlihat */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        text-align: center;
        font-weight: bold;
        z-index: 1000;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>
