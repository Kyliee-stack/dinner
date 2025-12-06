    <?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Jika menggunakan user login
                
                $table->string('nama_pelanggan');
                $table->integer('nomor_meja'); // Sesuai dengan input dari form pembayaran
                
                $table->unsignedBigInteger('subtotal');
                $table->unsignedBigInteger('biaya_lainnya')->default(0); // Biaya layanan, pembulatan, dll.
                $table->unsignedBigInteger('total');
                
                $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('orders');
        }
    };