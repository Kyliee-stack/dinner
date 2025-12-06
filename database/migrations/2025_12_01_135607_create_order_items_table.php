<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke orders
            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();
            
            // Relasi ke menus
            $table->foreignId('menu_id')
                  ->nullable()
                  ->constrained('menus')
                  ->nullOnDelete();

            $table->string('nama_menu'); 
            $table->unsignedInteger('qty');
            $table->unsignedBigInteger('harga_satuan');
            $table->unsignedBigInteger('subtotal');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
