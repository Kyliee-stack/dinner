<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Gacoan')</title>
    
    {{-- Font Awesome untuk Ikon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: #e3342f; /* Merah Gacoan */
            --color-primary-dark: #c72c27;
            --color-secondary: #f4f6f9; /* Background utama */
            --color-dark: #343a40;
            --color-text-sidebar: #ced4da;
            --color-active-bg: #495057;
        }
        /* ... (Semua CSS Anda yang lain di sini) ... */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-secondary);
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }
        
        /* ------------------------------------- */
        /* SIDEBAR (MENU SAMPING) */
        /* ------------------------------------- */
        .sidebar {
            width: 250px;
            background-color: var(--color-dark);
            color: var(--color-text-sidebar);
            padding: 20px 0;
            position: fixed;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        .sidebar-header {
            text-align: center;
            padding: 0 20px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #495057;
        }
        .sidebar-header h3 {
            color: white;
            margin: 0;
            font-weight: 800;
            font-size: 1.5rem;
        }

        .sidebar-nav {
            flex-grow: 1;
            list-style: none;
            padding: 0 20px;
            margin: 0;
        }
        .sidebar-nav li {
            margin-bottom: 10px;
        }
        .sidebar-nav a {
            display: block;
            color: var(--color-text-sidebar);
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            transition: background-color 0.2s, color 0.2s;
            font-weight: 500;
        }
        .sidebar-nav a:hover {
            background-color: var(--color-active-bg);
            color: white;
        }
        .sidebar-nav a.active {
            background-color: var(--color-primary);
            color: white;
            font-weight: 700;
        }
        .sidebar-nav a i {
            margin-right: 10px;
        }

        /* Tombol Logout di Bawah */
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #495057;
        }
        .sidebar-footer button {
            width: 100%;
            background-color: var(--color-primary);
            color: white;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .sidebar-footer button:hover {
            background-color: var(--color-primary-dark);
        }

        /* ------------------------------------- */
        /* MAIN CONTENT AREA */
        /* ------------------------------------- */
        .main-content {
            margin-left: 250px; /* Lebar Sidebar */
            flex-grow: 1;
            width: calc(100% - 250px);
            display: flex;
            flex-direction: column;
        }

        /* HEADER */
        .header {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--color-dark);
        }
        
        /* TOMBOL RESPONSIVE */
        .sidebar-toggle {
            display: none; /* Sembunyikan secara default di desktop */
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--color-dark);
            cursor: pointer;
            padding: 0;
            margin-right: 15px;
        }
        
        /* CONTENT WRAPPER */
        .content-wrapper {
            padding: 30px;
            flex-grow: 1;
        }
        
        /* ------------------------------------- */
        /* RESPONSIVE DESIGN */
        /* ------------------------------------- */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-250px);
                position: fixed;
                top: 0;
                left: 0;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .sidebar-toggle {
                display: block; /* Tampilkan di mobile/tablet */
            }
            .header {
                justify-content: flex-start;
            }
            .header h1 {
                font-size: 1.25rem;
            }
        }
        
        /* GLOBAL TABLE STYLE */
        .data-table table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            margin-top: 10px;
        }
        .data-table th, .data-table td {
            padding: 12px 15px;
            text-align: left;
        }
        .data-table th {
            background-color: #e9ecef;
            color: var(--color-dark);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .data-table tr:first-child th:first-child { border-top-left-radius: 10px; }
        .data-table tr:first-child th:last-child { border-top-right-radius: 10px; }
        
        .data-table tbody tr {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.2s;
        }
        .data-table tbody tr:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* GLOBAL ALERT & BUTTON STYLES (Dipakai di Dashboard/Orders) */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #c3e6cb;
        }
        .alert-info {
            background-color: #cce5ff;
            color: #004085;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #b8daff;
        }
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            margin-right: 5px;
            display: inline-flex;
            align-items: center;
        }
        .btn-action i {
            margin-right: 5px;
        }
        .btn-action.detail {
            background-color: #17a2b8;
            color: white;
        }
        
        /* Tambahkan CSS untuk Form Edit (digunakan di inventories/edit) */
        .data-form {
            max-width: 700px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .data-form h3 {
            color: var(--color-primary);
            margin-top: 0;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-sizing: border-box;
        }
        .form-group-row {
            display: flex;
            gap: 20px;
        }
        .form-group-row .form-group {
            flex: 1;
        }
        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-primary i, .btn-secondary i {
            margin-right: 8px;
        }
        .required { color: var(--color-primary); }
        .error-message {
            color: var(--color-primary);
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    {{-- SIDEBAR --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Dashboard ADMIN</h3>
        </div>

        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}" 
                   class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> Pesanan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.menus.index') }}" 
                   class="{{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                    <i class="fas fa-utensils"></i> Menu
                </a>
            </li>
            <li>
                <a href="{{ route('admin.inventories.index') }}"
                   class="{{ request()->routeIs('admin.inventories.*') ? 'active' : '' }}">
                    <i class="fas fa-warehouse"></i> Inventaris
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            {{-- Form Logout. Diubah menggunakan URL statis jika route name admin.logout tidak ada. --}}
            <form id="logout-form" method="POST" action="/admin/logout">
                @csrf
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="main-content">
        {{-- HEADER / JUDUL HALAMAN --}}
        <header class="header">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Navigation">
                <i class="fas fa-bars"></i>
            </button>
            <h1>@yield('page_title', 'Admin Panel')</h1>
        </header>

        {{-- KONTEN UTAMA --}}
        <main class="content-wrapper">
            @yield('content')
        </main>
    </div>

    {{-- ELEMEN AUDIO YANG DISEMBUNYIKAN (DIJAMIN HANYA ADA SATU) --}}
    <audio id="notificationSound" src="{{ asset('audio/notif.mp3') }}" preload="auto" style="display: none;"></audio>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebarToggle');
            const mainContent = document.querySelector('.main-content');
            
            // Logika untuk toggle sidebar
            if (toggleButton) {
                toggleButton.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                });
            }

            // Opsional: Tutup sidebar saat klik di luar (hanya untuk mobile)
            if (window.innerWidth <= 992) {
                mainContent.addEventListener('click', function() {
                    if (sidebar.classList.contains('open')) {
                        sidebar.classList.remove('open');
                    }
                });
            }
            
            // ------------------------------------------------------------------
            // >>> KODE NOTIFIKASI SUARA REAL-TIME (Sudah digabung) <<<
            // ------------------------------------------------------------------
            const audio = document.getElementById('notificationSound');

            if (window.Echo) {
                window.Echo.private('orders')
                    .listen('OrderPlaced', (e) => {
                        console.log('🚨 Pesanan Baru Masuk:', e);
                        
                        // Memicu pemutaran audio
                        audio.play().then(() => {
                            console.log('Suara notifikasi diputar.');
                        }).catch(error => {
                            console.warn('Gagal memutar suara (diblokir oleh browser):', error);
                            
                            if (error.name === 'NotAllowedError') {
                                // Tampilkan peringatan jika diblokir oleh kebijakan Autoplay browser
                                alert('🔔 Notifikasi Suara diblokir. Klik di mana saja di halaman ini agar suara notifikasi berikutnya dapat berbunyi.');
                            }
                        });
                    });
            }
        });
    </script>
</body>
</html>