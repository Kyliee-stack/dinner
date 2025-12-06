<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'order_id',
        'menu_id',
        'nama_menu',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    // Hubungan: Satu OrderItem dimiliki oleh satu Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Hubungan: Satu OrderItem merujuk ke satu Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}