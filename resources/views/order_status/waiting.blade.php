<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Konfirmasi - Pesanan #{{ $order->order_number }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #e3342f; /* Merah Gacoan */
            --color-secondary: #f4f6f9;
            --color-dark: #343a40;
            --color-warning: #ffc107;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-secondary);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 600px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            text-align: center;
        }
        h1 {
            color: var(--color-dark);
            font-size: 2rem;
            margin-bottom: 5px;
        }
        .order-id {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 25px;
            font-weight: 500;
        }
        .status-box {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .status-box i {
            font-size: 2.5rem;
            margin-bottom: 10px;
            animation: pulse 1.5s infinite;
        }
        .status-box p {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }
        .loading-animation {
            height: 4px;
            background-color: var(--color-primary);
            width: 0;
            border-radius: 2px;
            animation: progress 8s infinite linear;
            margin: 15px auto;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }
        @keyframes progress {
            0% { width: 0; }
            100% { width: 100%; }
        }
        .detail-summary {
            text-align: left;
            padding: 15px;
            border-top: 1px dashed #ccc;
            border-bottom: 1px dashed #ccc;
            margin-bottom: 25px;
        }
        .detail-summary strong {
            display: inline-block;
            width: 150px;
            color: var(--color-dark);
        }
        .detail-summary p {
            margin: 5px 0;
        }
        .error-message {
            color: var(--color-primary);
            margin-top: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1><i class="fas fa-hourglass-half"></i> Menunggu Konfirmasi</h1>
            <p class="order-id">Pesanan Anda: #{{ $order->order_number }}</p>
        </header>

        <div class="status-box">
            <i class="fas fa-hand-paper"></i>
            <p id="current-status">Menunggu Konfirmasi Admin / Pembayaran</p>
        </div>
        
        <div class="loading-animation"></div>

        <div class="detail-summary">
            <p><strong>Nama Pelanggan:</strong> {{ $order->customer_name }}</p>
            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
        </div>

        <p id="message">Kami sedang memproses pesanan Anda. Halaman ini akan diperbarui secara otomatis.</p>
        <p class="error-message" id="polling-error" style="display: none;">Gagal mengecek status. Mencoba kembali dalam 5 detik...</p>
        
        <a href="{{ route('menu.index') }}" style="display: inline-block; margin-top: 20px; color: #007bff; text-decoration: none;">
            <i class="fas fa-home"></i> Kembali ke Menu
        </a>
    </div>

    <script>
        const orderNumber = "{{ $order->order_number }}";
        const checkStatusUrl = "{{ route('order.checkStatus', $order->order_number) }}";
        const successUrl = "{{ route('order.success', $order->order_number) }}";
        let attempt = 0;
        const maxRetries = 10; // Batas percobaan sebelum berhenti

        // Fungsi untuk melakukan polling status
        function checkOrderStatus() {
            fetch(checkStatusUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('polling-error').style.display = 'none';
                    const status = data.status;
                    document.getElementById('current-status').textContent = status;

                    // Jika status berubah menjadi 'Dikonfirmasi' atau 'Selesai', alihkan ke halaman sukses
                    if (status === 'Dikonfirmasi' || status === 'Diproses' || status === 'Siap Diambil' || status === 'Selesai') {
                        // Jika sudah dikonfirmasi, kita anggap sukses dan alihkan
                        window.location.href = successUrl;
                    } 
                    // Jika status 'Dibatalkan', tampilkan pesan dan hentikan polling
                    else if (status === 'Dibatalkan') {
                        document.getElementById('message').textContent = 'Pesanan Anda telah dibatalkan oleh Admin.';
                    } else {
                        // Terus polling jika status masih 'Menunggu Konfirmasi'
                        setTimeout(checkOrderStatus, 5000); // Polling setiap 5 detik
                    }
                })
                .catch(error => {
                    console.error('Polling error:', error);
                    document.getElementById('polling-error').style.display = 'block';
                    
                    attempt++;
                    if (attempt < maxRetries) {
                         // Mencoba lagi dengan Exponential Backoff sederhana (2, 4, 8, 16 detik)
                        const delay = Math.min(5000 * Math.pow(2, attempt), 30000); // Max delay 30s
                        setTimeout(checkOrderStatus, delay); 
                    } else {
                        document.getElementById('message').textContent = 'Terjadi kesalahan serius. Silakan hubungi Kasir.';
                        document.getElementById('polling-error').style.display = 'none';
                    }
                });
        }

        // Mulai polling saat halaman dimuat
        window.onload = checkOrderStatus;
    </script>

</body>
</html>