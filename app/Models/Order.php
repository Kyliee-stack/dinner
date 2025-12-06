<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Pastikan semua kolom yang akan diisi via mass assignment ada di sini
    protected $fillable = [
        'order_number',
        'nama_menu',
        'nama_pelanggan', // FIX: Kolom wajib diisi
        'nomor_meja',     // FIX: Kolom wajib diisi
        'order_type',
        'payment_method',
        'notes',
        'status',
        'subtotal',       // FIX: Menggantikan 'total_harga'
        'biaya_lainnya',
        'discount',
        'total',          // FIX: Kolom total (mungkin sama dengan grand_total sebelum diskon)
        'grand_total'     // FIX: Kolom akhir
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}