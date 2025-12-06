<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    // Fungsi untuk menampilkan form tambah stok masuk
    public function createIn()
    {
        $inventories = Inventory::all();
        return view('admin.transactions.create_in', compact('inventories'));
    }

    // Fungsi untuk memproses penambahan stok (Stok Masuk)
    public function storeIn(Request $request)
    {
        $data = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'quantity' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $inventory = Inventory::find($data['inventory_id']);
        
        // 1. Catat Transaksi
        StockTransaction::create([
            'inventory_id' => $inventory->id,
            'type' => 'IN',
            'quantity' => $data['quantity'],
            'transaction_date' => $data['transaction_date'],
            'notes' => $data['notes'] ?? 'Stok Masuk'
        ]);
        
        // 2. Update Stok di Master Data
        $inventory->current_stock += $data['quantity'];
        
        // 3. Update Status Kritis
        $inventory->is_critical = $inventory->current_stock < $inventory->min_stock_level;
        
        $inventory->save();

        return redirect()
            ->route('admin.inventories.index')
            ->with('success', 'Stok Masuk berhasil dicatat! Stok saat ini: ' . number_format($inventory->current_stock, 2));
    }

    // Anda juga perlu membuat fungsi storeOut() untuk Stok Keluar, 
    // di mana Anda akan menggunakan: $inventory->current_stock -= $data['quantity'];
}