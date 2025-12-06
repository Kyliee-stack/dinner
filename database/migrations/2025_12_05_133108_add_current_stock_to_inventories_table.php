<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk menambahkan kolom 'current_stock' dan 'min_stock_level'.
 * Ini adalah kolom yang dicari oleh InventoryController dan menyebabkan QueryException.
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Kolom 'current_stock'
            if (!Schema::hasColumn('inventories', 'current_stock')) {
                // Kolom akan ditambahkan setelah 'unit' (yang sudah ada dari migrasi sebelumnya)
                $table->integer('current_stock')->default(0); 
            }

            // Kolom 'min_stock_level'
            if (!Schema::hasColumn('inventories', 'min_stock_level')) {
                $table->integer('min_stock_level')->default(0)->after('current_stock');
            }
            
            // Kolom 'is_critical' (untuk performa, agar tidak perlu dihitung setiap saat)
            if (!Schema::hasColumn('inventories', 'is_critical')) {
                $table->boolean('is_critical')->default(false)->after('min_stock_level');
            }
        });
    }

    /**
     * Membatalkan migrasi (rollback).
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (Schema::hasColumn('inventories', 'is_critical')) {
                $table->dropColumn('is_critical');
            }
            if (Schema::hasColumn('inventories', 'min_stock_level')) {
                $table->dropColumn('min_stock_level');
            }
            if (Schema::hasColumn('inventories', 'current_stock')) {
                $table->dropColumn('current_stock');
            }
        });
    }
};