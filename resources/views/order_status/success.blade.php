<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Dikonfirmasi - #{{ $order->order_number }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #e3342f; /* Merah Gacoan */
            --color-secondary: #f4f6f9;
            --color-dark: #343a40;
            --color-success: #28a745;
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
        .success-icon {
            color: var(--color-success);
            font-size: 4rem;
            margin-bottom: 20px;
            animation: bounce 0.5s ease-out;
        }
        @keyframes bounce {
            0% { transform: scale(0.5); opacity: 0; }
            70% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); }
        }
        h1 {
            color: var(--color-success);
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .status-message {
            color: var(--color-dark);
            font-size: 1.2rem;
            margin-bottom: 30px;
            font-weight: 500;
        }
        .order-details {
            background-color: #e6ffed;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #c3e6cb;
            text-align: left;
            margin-bottom: 30px;
        }
        .order-details p {
            margin: 8px 0;
        }
        .order-details strong {
            display: inline-block;
            width: 180px;
            color: #155724;
        }
        .note {
            font-style: italic;
            color: #6c757d;
            margin-top: 20px;
            font-size: 0.95rem;
        }
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #c72c27;
        }
    </style>
</head>
<body>

    <div class="container">
        <i class="fas fa-check-circle success-icon"></i>
        <h1>Pesanan Dikonfirmasi!</h1>
        <p class="status-message">Pesanan Anda telah dikonfirmasi dan sedang diproses.</p>

        <div class="order-details">
            <p><strong>Nomor Pesanan:</strong> #{{ $order->order_number }}</p>
            <p><strong>Status Saat Ini:</strong> <span style="color: var(--color-success);">{{ $order->status }}</span></p>
            <p><strong>Nama Pelanggan:</strong> {{ $order->customer_name }}</p>
            <p><strong>Tipe Pesanan:</strong> {{ $order->order_type }}</p>
            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
        </div>

        <a href="{{ route('menu.index') }}" class="btn-primary">
            <i class="fas fa-utensils"></i> Pesan Lagi
        </a>

        <p class="note">Anda dapat menanyakan status pesanan ini kepada kasir/pelayan dengan menyebutkan Nomor Pesanan di atas.</p>
    </div>

</body>
</html>