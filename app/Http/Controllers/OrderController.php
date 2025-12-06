<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Inventory; // Tambahkan import Model Inventory
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Tambahkan import Log

class OrderController extends Controller
{
    // Daftar status yang valid untuk pesanan
    private $validStatuses = ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Diproses', 'Siap Diambil', 'Selesai', 'Dibatalkan'];

    // ===============================================
    // FRONT-END (Customer)
    // ===============================================

    // Menampilkan halaman checkout (form data pembeli)
    public function checkout()
    {
        // Mendapatkan data keranjang dari session
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            // Jika keranjang kosong, redirect kembali ke menu
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda masih kosong. Silakan pilih menu terlebih dahulu.');
        }

        // Opsional: Hitung subtotal di sini jika diperlukan di view checkout
        // $subtotal = collect($cart)->sum(fn($item) => $item['quantity'] * $item['price']);

        return view('checkout');
    }

    // Memproses checkout (menyimpan pesanan ke database)
    // Memproses checkout (menyimpan pesanan ke database)
    // Memproses checkout (menyimpan pesanan ke database)
    public function processCheckout(Request $request)
    {
        // PERBAIKAN: Gunakan 'nullable' untuk kolom opsional
        $request->validate([
            'nama_pelanggan' => 'nullable|string|max:255', 
            'order_type' => 'required|in:Dine-In,Take-Away',
            'payment_method' => 'required|in:Tunai,Transfer Bank',
            'notes' => 'nullable|string|max:500',
            'nomor_meja' => 'nullable|integer|min:0', // Pastikan ini juga nullable jika opsional
        ]);

        $cart = session()->get('cart', []);
        
        // Normalisasi cart (biarkan tetap)
        $normalizedCart = [];
        foreach ($cart as $k => $it) {
            if (!isset($it['quantity']) && isset($it['qty'])) {
                $it['quantity'] = $it['qty'];
            }
            if (!isset($it['qty']) && isset($it['quantity'])) {
                $it['qty'] = $it['quantity'];
            }
            $normalizedCart[$k] = $it;
        }
        $cart = $normalizedCart;

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong. Proses checkout dibatalkan.');
        }

        try {
            DB::beginTransaction();

            $subtotal = collect($cart)->sum(fn($item) => $item['quantity'] * $item['price']);
            $grandTotal = $subtotal; 
            
            // Perhatikan penggunaan $request->input() dengan nilai default untuk mencegah error Undefined Key
            $order = Order::create([
                'order_number' => 'GACOAN-' . time(),
                
                // FIX UTAMA: Menggunakan input() dengan fallback ke 'Pelanggan Anonim' 
                'nama_pelanggan' => $request->input('nama_pelanggan', 'Pelanggan Anonim'),
                
                // Menggunakan input() dengan fallback ke 0 (sesuai DB default)
                'nomor_meja' => $request->input('nomor_meja', 0), 
                
                'order_type' => $request->input('order_type'),
                'status' => 'Menunggu Konfirmasi', 
                'payment_method' => $request->input('payment_method'),
                
                'subtotal' => $subtotal, 
                'total' => $grandTotal, 
                'grand_total' => $grandTotal, 
                
                'discount' => $request->input('discount', 0),
                'biaya_lainnya' => $request->input('biaya_lainnya', 0), 
                
                // Menggunakan input() dengan fallback untuk notes juga
                'notes' => $request->input('notes', null), 
            ]);

            // Simpan detail item pesanan
          // Simpan detail item pesanan
foreach ($cart as $id => $item) {
    OrderItem::create([
        'order_id' => $order->id,
        'menu_id' => $id,
        
        // FIX: Tambahkan menu_name (sesuai pesan error 'nama_menu')
        'nama_menu' => $item['name'], // Kita ambil dari data item keranjang
        
        'harga_satuan' => $item['price'],
        'qty' => $item['quantity'],
        'subtotal' => $item['quantity'] * $item['price'],
        'notes' => $item['notes'] ?? null,
    ]);
}

            session()->forget('cart');
            DB::commit();
            return redirect()->route('order.waiting', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error saat memproses checkout: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
         

    // Halaman menunggu konfirmasi pembayaran/pesanan
    public function waiting($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        return view('order_status.waiting', compact('order'));
    }

    /**
     * Cek status pesanan secara berkala (Ajax/Polling).
     * Dipanggil oleh script JS di halaman waiting.
     */
    public function checkStatus($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        return response()->json(['status' => $order->status]);
    }

    // Halaman sukses pesanan
    public function success($order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        return view('order_status.success', compact('order'));
    }

    // ===============================================
    // ADMIN PANEL
    // ===============================================

    // Tampilkan daftar pesanan untuk Admin
    public function index(Request $request)
    {
        $statusFilter = $request->query('status', 'Menunggu Konfirmasi');
        
        $orders = Order::with('items')
            ->when($statusFilter && $statusFilter !== 'Semua', function ($query) use ($statusFilter) {
                return $query->where('status', $statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('orders.index', [
            'orders' => $orders,
            'currentStatus' => $statusFilter,
            'statuses' => $this->validStatuses,
        ]);
    }

    // Tampilkan detail pesanan untuk Admin
    public function show(Order $order)
    {
        $order->load('items.menu'); // Load item dan detail menu terkait
        
        return view('orders.show', [
            'order' => $order,
            'statuses' => $this->validStatuses,
        ]);
    }

    /**
     * Mengupdate status pesanan.
     * INI ADALAH FUNGSI KONFIRMASI UTAMA ADMIN.
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Validasi status baru harus sesuai dengan daftar yang valid
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', $this->validStatuses),
        ]);

        $newStatus = $validated['status'];
        
        try {
            DB::beginTransaction();

            // 1. Logika Utama: Update Status
            $order->status = $newStatus;
            $order->save();

            // 2. Jika status diubah menjadi "Dikonfirmasi", lakukan aksi tambahan:
            if ($newStatus === 'Dikonfirmasi') {
                // Panggil fungsi pengurangan stok
                $this->deductInventory($order); 
            }
            
            DB::commit();

            // Redirect kembali ke halaman detail pesanan dengan pesan sukses
            return redirect()->route('admin.orders.show', $order)
                ->with('success', "Status pesanan #{$order->order_number} berhasil diubah menjadi '{$newStatus}'.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal mengupdate status pesanan #{$order->order_number} atau mengurangi stok: " . $e->getMessage());

            // Tambahkan notifikasi error jika gagal
            return redirect()->back()
                ->with('error', "Gagal mengupdate status. Error: " . $e->getMessage());
        }
    }

    /**
     * Logika untuk mengurangi stok di Inventory berdasarkan item pesanan.
     * * CATATAN PENTING:
     * Dalam kasus nyata, Anda akan menggunakan tabel 'Recipe' untuk memetakan Menu ID
     * ke beberapa Inventory Item (e.g., Mie Setan -> Mie Mentah + Cabai + Minyak).
     * * Implementasi di bawah ini menggunakan ASUMSI sederhana:
     * - Menu 'Mie Iblis' (ID: 1) mengurangi 'Mie Kering' (ID: 1)
     * - Menu 'Es Genderuwo' (ID: 2) mengurangi 'Es Batu' (ID: 2)
     * - Dan seterusnya.
     */
    private function deductInventory(Order $order)
    {
        // Muat detail item pesanan
        $order->load('items');
        
        foreach ($order->items as $item) {
            // ASUMSI: Inventory ID = Menu ID
            // Gantilah dengan logika pencarian resep yang sebenarnya di Production
            $inventoryItem = Inventory::find($item->menu_id);

            // Jika item inventaris ditemukan
            if ($inventoryItem) {
                // Hitung stok baru
                $newStock = $inventoryItem->current_stock - $item->quantity;

                if ($newStock < 0) {
                    // Jika stok tidak mencukupi, lempar Exception (batalkan transaksi)
                    throw new \Exception("Stok tidak mencukupi untuk item: {$inventoryItem->item_name}. Permintaan: {$item->quantity}. Stok saat ini: {$inventoryItem->current_stock}.");
                }

                // Update stok
                $inventoryItem->current_stock = $newStock;
                
                // Cek apakah status menjadi kritis
                if ($newStock < $inventoryItem->min_stock_level) {
                    $inventoryItem->is_critical = true;
                    // TODO: Di sini adalah tempat ideal untuk memicu notifikasi stok kritis ke Admin
                    Log::warning("Stok Kritis: {$inventoryItem->item_name} berada di bawah batas minimum ({$inventoryItem->min_stock_level}).");
                } else {
                    $inventoryItem->is_critical = false;
                }

                $inventoryItem->save();
                Log::info("Stok {$inventoryItem->item_name} dikurangi sebanyak {$item->quantity}. Sisa stok: {$inventoryItem->current_stock}.");
            } else {
                // Log jika item Inventory tidak ditemukan (ini menunjukkan missing data)
                Log::warning("Item Inventory tidak ditemukan untuk menu ID: {$item->menu_id} ({$item->menu_name}). Stok tidak dikurangi.");
            }
        }
    }
}