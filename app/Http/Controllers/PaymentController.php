<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Menampilkan formulir (halaman) pembayaran.
     */
    public function showPaymentForm()
    {
        // Ambil data keranjang dari session
        $cart = Session::get('cart', []);

        // Anda perlu menghitung ringkasan keranjang lagi di sini
        // Idealnya, Anda memanggil fungsi calculateCartSummary dari PemesananController
        // Atau memindahkan calculateCartSummary ke service/helper
        
        // Untuk saat ini, kita akan meneruskan data keranjang mentah
        // dan membuat view sederhana.

        // Jika keranjang kosong, redirect kembali ke menu
        if (empty($cart)) {
             return redirect()->route('menu.index')->with('error', 'Keranjang kosong, tidak bisa melanjutkan ke pembayaran.');
        }

        // TODO: Anda harus menghitung ringkasan pembayaran di sini.
        // Asumsi data ini sudah dihitung dan siap dari CartController atau helper.
        $cartSummary = [
            'total_pembayaran' => 0, // Placeholder
            'item_count' => count($cart),
        ];

        return view('payment', compact('cart', 'cartSummary'));
    }
}