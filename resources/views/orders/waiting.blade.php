@extends('layouts.app')

@section('content')
<div style="padding: 20px; text-align: center;">
    <h2>⏳ Menunggu Konfirmasi Kasir</h2>
    <p>Order ID: {{ $order->id }}</p>
    <p>Status saat ini: <strong id="status-text">{{ $order->status }}</strong></p>

    <p>Halaman ini akan otomatis cek status setiap 3 detik...</p>
</div>

<script>
    setInterval(() => {
        fetch("{{ route('order.checkStatus', $order->id) }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('status-text').innerText = data.status;

                if (data.status === 'success') {
                    window.location.href = "{{ route('order.success', $order->id) }}";
                }
            });
    }, 3000);
</script>
@endsection
