<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; 

class MenuController extends Controller
{
    /**
     * Menampilkan daftar menu berdasarkan kategori dari database.
     */
    public function index(Request $request)
    {
        // 1. Ambil kategori dari query string (URL), default-nya diubah ke kategori baru
        // Ini adalah kategori default yang baru setelah seeder berhasil
        $rawCategory = $request->get('category', 'MAKANAN BERAT (Mie, Nasi, Roti)');
        $category = strtoupper($rawCategory); 
        
        // 2. Ambil semua data cart dari session
        $cart = session()->get('cart', []);
        
        // 3. Query Menu dari Database menggunakan filtering case-insensitive (PENTING!)
        // Membandingkan kolom 'category' di DB dengan nilai kategori yang sudah di-lowercase.
        $menus = Menu::whereRaw('LOWER(category) = ?', [strtolower($rawCategory)])
                      ->get();
        
        // 4. Hitung ringkasan keranjang untuk Bottom Bar
        $itemCount = 0;
        $totalPembayaran = 0;

        foreach ($cart as $item) {
            $itemCount += $item['qty'] ?? 0;
            $totalPembayaran += ($item['price'] ?? 0) * ($item['qty'] ?? 0);
        }

      $cartSummary = [
    'item_count' => $itemCount,
    'total_pembayaran' => $totalPembayaran,
    'subtotal' => $totalPembayaran,
    'pembulatan' => 0,
    'biaya_lainnya' => 0,
];

        // Kirim $menus (dari database), $category (untuk tab), $cart, dan $cartSummary ke View
        return view('menu', compact('menus', 'category', 'cart', 'cartSummary'));
    }
    
    // START CART FUNCTIONS (Pastikan fungsi ini ada)
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);
        $menuId = $request->menu_id;
        $qtyToAdd = $request->qty;

        $menuItem = Menu::find($menuId);

        if (!$menuItem) {
            session()->flash('error', 'Menu tidak ditemukan.');
            return redirect()->back();
        }

        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += $qtyToAdd;
        } else {
            $cart[$menuId] = [
                "id"    => $menuItem->id,
                "name"  => $menuItem->nama,
                "price" => $menuItem->harga,
                "qty"   => $qtyToAdd
            ];
        }

        session()->put('cart', $cart);
        session()->flash('success', $menuItem->nama . ' ditambahkan ke keranjang.');
        return redirect()->back();
    }

    public function cart()
    {
        $cart = session('cart', []);
        $total = 0;
        $itemCount = 0;

        foreach ($cart as $item) {
            $quantity = $item['qty'] ?? 0; 
            $total += $item['price'] * $quantity;
            $itemCount += $quantity;
        }

        $cartSummary = [
    'item_count' => $itemCount,
    'total_pembayaran' => $total,
    'subtotal' => $total,      // biar aman
    'pembulatan' => 0,         // default
    'biaya_lainnya' => 0,      // default
];


        return view('cart', compact('cart', 'cartSummary'));
    }
    
  public function updateCart(Request $request)
{
    $menuId = $request->menu_id;
    $newQty = (int) $request->qty;

    $cart = session()->get('cart', []);

    if (!isset($cart[$menuId])) {
        return back()->with('error', 'Item tidak ditemukan di keranjang.');
    }

    if ($newQty <= 0) {
        unset($cart[$menuId]);
    } else {
        $cart[$menuId]['qty'] = $newQty;
    }

    session()->put('cart', $cart);

    return back();
}

    
    public function removeCart(Request $request)
    {
        $menuId = $request->menu_id;

        if ($menuId) {
            $cart = session()->get('cart', []);

            if (isset($cart[$menuId])) {
                $itemName = $cart[$menuId]['name'];
                unset($cart[$menuId]);
                session()->put('cart', $cart);
                session()->flash('warning', $itemName . ' dihapus dari keranjang.');
            }
        }

        return redirect()->back();
    }

   public function checkout(Request $request)
{
    $cart = session()->get('cart', []);

    if (!$cart || count($cart) == 0) {
        return redirect()->back()->with('error', 'Keranjang kosong!');
    }

    // Hitung total
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    // Simpan ke tabel orders
    $order = \App\Models\Order::create([
        'nama_pemesan' => $request->nama_pemesan ?? 'Guest',
        'total_harga' => $total,
    ]);

    // Simpan order_items
    foreach ($cart as $item) {
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $item['id'],
            'qty' => $item['qty'],
            'sub_total' => $item['qty'] * $item['price'],
        ]);
    }

    // Hapus cart
    session()->forget('cart');

    return redirect('/success')->with('success', 'Pesanan berhasil dibuat!');
}

}