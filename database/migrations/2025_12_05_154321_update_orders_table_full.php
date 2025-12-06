<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        // Tambah kolom baru
        $table->string('order_number')->unique()->after('id');
        $table->string('customer_name')->nullable()->after('user_id');
        $table->enum('order_type', ['Dine-In', 'Take-Away'])->default('Take-Away')->after('customer_name');
        $table->enum('payment_method', ['Tunai', 'Transfer Bank'])->default('Tunai')->after('order_type');
        $table->text('notes')->nullable()->after('payment_method');

        $table->integer('subtotal')->default(0)->change();
        $table->integer('total')->default(0)->change();
        $table->integer('biaya_lainnya')->default(0)->change();

        $table->integer('discount')->default(0)->after('biaya_lainnya');
        $table->integer('grand_total')->default(0)->after('discount');

        // Pastikan status aman
        $table->string('status')->default('Menunggu Konfirmasi')->change();
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn([
            'order_number', 'customer_name', 'order_type', 'payment_method',
            'notes', 'discount', 'grand_total'
        ]);
    });
}

};
