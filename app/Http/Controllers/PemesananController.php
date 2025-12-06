<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
// Import model lain yang diperlukan (Order, OrderItem)

class PemesananController extends Controller
{
    /**
     * Menampilkan halaman menu utama (index) dengan fitur filter kategori.
     */
    public function index(Request $request)
    {
        // 1. Ambil kategori dari query string, default-nya 'MIE DINE IN'
        $category = $request->get('category', 'MIE DINE IN');

        // 2. Filter Menu berdasarkan kategori yang diminta
        $menusQuery = Menu::query();
        
        // Sesuaikan dengan kolom kategori di tabel 'menus' Anda
        // Catatan: Jika Anda menggunakan huruf besar/kecil di DB, gunakan whereRaw(LOWER(col) = lower(?))
        $menus = $menusQuery->where('category', $category)->get(); 
        
        // Data keranjang
        $cart = session()->get('cart', []);
        
        // Hitung total harga keranjang untuk ditampilkan di Bottom Bar
        $cartSummary = $this->calculateCartSummary($cart); 

        return view('menu', compact('menus', 'cart', 'cartSummary', 'category')); // Kirimkan juga $category
    }

    /**
     * Menambahkan item menu ke keranjang (Session) melalui POST form.
     * (Tidak ada perubahan, sudah baik)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'required|integer|min:1',
        ]);

        $menuId = $request->menu_id;
        $qty = $request->qty;

        $menu = Menu::find($menuId);
        $cart = session()->get('cart', []);

        // Jika item sudah ada, tambahkan kuantitasnya
        if(isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += $qty;
        } else {
            // Jika item belum ada, buat entri baru
            $cart[$menuId] = [
                "id" => $menu->id,
                "nama" => $menu->nama,
                "harga" => $menu->harga, 
                "qty" => $qty,
                "keterangan" => $request->keterangan ?? null
            ];
        }

        session()->put('cart', $cart);

        // Redirect kembali, pertahankan kategori agar tetap di tab yang sama
        $category = $request->input('category_aktif'); // Ambil kategori dari hidden input di form
        return redirect()->route('menu.index', ['category' => $category])->with('success', $menu->nama . ' berhasil ditambahkan ke keranjang.');
    }

    /**
     * Memperbarui kuantitas item di keranjang (Digunakan oleh tombol Minus/Plus di menu/cart).
     * (Tidak ada perubahan, sudah baik)
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'required|integer|min:0',
        ]);

        $menuId = $request->menu_id;
        $qty = $request->qty;
        $cart = session()->get('cart');

        if(isset($cart[$menuId])) {
            if ($qty <= 0) {
                unset($cart[$menuId]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
            }
            
            $cart[$menuId]['qty'] = $qty;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Kuantitas berhasil diubah.');
    }
    
    /**
     * FUNGSI BANTU: Menghitung ringkasan total keranjang.
     * (Tidak ada perubahan, sudah baik)
     */
    protected function calculateCartSummary(array $cart)
    {
        $subtotal = 0;
        $itemCount = 0;

        foreach ($cart as $item) {
            $price = $item['harga'] ?? 0;
            $qty = $item['qty'] ?? 0;

            $subtotal += ($price * $qty);
            $itemCount += $qty;
        }

        $biayaLainnya = round($subtotal * 0.10); 
        $totalSementara = $subtotal + $biayaLainnya;
        
        $total_pembayaran = ceil($totalSementara / 1000) * 1000;
        
        $pembulatan = $total_pembayaran - $totalSementara;

        return [
            'item_count' => $itemCount,
            'subtotal' => $subtotal,
            'biaya_lainnya' => $biayaLainnya,
            'pembulatan' => $pembulatan,
            'total_pembayaran' => $total_pembayaran,
        ];
    }
    
    /**
     * Menampilkan halaman rincian keranjang (cart.blade.php).
     * (Tidak ada perubahan, sudah baik)
     */
    public function showCart()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda kosong.');
        }

        $cartSummary = $this->calculateCartSummary($cart); 
        
        return view('cart', [
            'items' => $cart,
            'cartSummary' => $cartSummary
        ]);
    }

    /**
     * Menghapus item dari keranjang (di halaman cart.blade.php).
     * (Tidak ada perubahan, sudah baik)
     */
    public function removeItem(Request $request)
    {
        $request->validate(['menu_id' => 'required|exists:menus,id']);
        $menuId = $request->menu_id;
        $cart = session()->get('cart');

        if(isset($cart[$menuId])) {
            unset($cart[$menuId]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item berhasil dihapus.');
        }

        return redirect()->back();
    }
    
    // ... method-method lain
}