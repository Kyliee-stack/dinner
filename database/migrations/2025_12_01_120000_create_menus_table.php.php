<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('menus', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->unsignedInteger('harga');
    $table->string('kategori')->nullable(); 
    $table->string('category', 50)->nullable(); 
    $table->text('deskripsi')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};