@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f0f0f0;
    }
    .checkout-container {
        padding: 20px;
        max-width: 500px;
        margin: 30px auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    h2 {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 25px;
        border-bottom: 2px solid #ff3366;
        padding-bottom: 10px;
    }
    label {
        display: block;
        font-weight: 600;
        margin-top: 15px;
        margin-bottom: 5px;
        color: #555;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        border-color: #ff3366;
        outline: none;
    }
    .rincian-judul {
        font-size: 1.25rem;
        font-weight: bold;
        color: #ff3366;
        margin-top: 30px;
        margin-bottom: 15px;
    }
    .rincian-baris {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
    }
    .rincian-baris.total-row {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #ddd;
        font-size: 1.1rem;
        font-weight: bold;
        color: #ff3366;
    }
    .submit-btn {
        width: 100%;
        background:#ff3366;
        color:white;
        padding:12px 20px;
        border:none;
        border-radius:8px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 30px;
        transition: background-color 0.3s;
    }
    .submit-btn:hover {
        background: #e62e5c;
    }
</style>

<div class="checkout-container">


<h2>📋 Isi Data Pembeli</h2>


@if ($errors->any())
<div style="background-color: #fee2e2; color: #dc2626; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<form action="{{ route('checkout') }}" method="POST">
@csrf


<label for="customer_name">Nama Pelanggan</label>
<input type="text" name="customer_name" id="customer_name"
class="form-control" value="{{ old('customer_name') }}" required>


<label for="nomor_hp">Nomor HP</label>
<input type="text" name="nomor_hp" id="nomor_hp"
class="form-control" value="{{ old('nomor_hp') }}">


<label for="email">Email</label>
<input type="email" name="email" id="email"
class="form-control" value="{{ old('email') }}">


<label for="nomor_meja">Nomor Meja (Optional)</label>
<input type="number" name="nomor_meja" id="nomor_meja"
class="form-control" value="{{ old('nomor_meja') }}">


{{-- Hidden defaults (tidak mengubah tampilan) --}}
<input type="hidden" name="order_type" value="Dine-In">
<input type="hidden" name="payment_method" value="Tunai">
<input type="hidden" name="notes" value="{{ old('notes', '') }}">


<h3 class="rincian-judul">💰 Rincian Pembayaran</h3>


<div class="rincian-baris">
<span>Subtotal:</span>
<span>Rp{{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
</div>


<div class="rincian-baris total-row">
<span>Total Pembayaran:</span>
<span>Rp{{ number_format($total ?? $subtotal ?? 0, 0, ',', '.') }}</span>
</div>


<button type="submit" class="submit-btn">
Buat Pesanan
</button>
</form>


</div>
@endsection