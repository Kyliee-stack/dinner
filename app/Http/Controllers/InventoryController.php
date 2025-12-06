<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::latest()->paginate(10);

        $criticalCount = Inventory::whereColumn(
            'current_stock',
            '<',
            'min_stock_level'
        )->count();

        return view('admin.inventories.index', compact(
            'inventories',
            'criticalCount'
        ));
    }

    public function create()
    {
        return view('admin.inventories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_name' => 'required',
            'unit' => 'required',
            'current_stock' => 'required|numeric',
            'min_stock_level' => 'required|numeric',
        ]);

        // Set otomatis status kritis
        $data['is_critical'] = $data['current_stock'] < $data['min_stock_level'];

        Inventory::create($data);

        return redirect()
            ->route('admin.inventories.index')
            ->with('success', 'Item stok berhasil ditambahkan!');
    }

    public function edit(Inventory $inventory)
    {
        return view('admin.inventories.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'item_name' => 'required',
            'unit' => 'required',
            'current_stock' => 'required|numeric',
            'min_stock_level' => 'required|numeric',
        ]);

        $data['is_critical'] = $data['current_stock'] < $data['min_stock_level'];

        $inventory->update($data);

        return redirect()
            ->route('admin.inventories.index')
            ->with('success', 'Item stok berhasil diperbarui!');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()
            ->route('admin.inventories.index')
            ->with('success', 'Item stok berhasil dihapus!');
    }
}
