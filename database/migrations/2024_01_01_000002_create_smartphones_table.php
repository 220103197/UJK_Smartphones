<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('smartphones', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('merek'); // Samsung, iPhone, Xiaomi, dll
            $table->string('model');
            $table->text('spesifikasi')->nullable();
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('harga_jual', 15, 2);
            $table->integer('stok')->default(0);
            $table->string('warna')->nullable();
            $table->string('kapasitas_storage')->nullable(); // 128GB, 256GB, dll
            $table->string('ram')->nullable(); // 8GB, 12GB, dll
            $table->enum('kondisi', ['baru', 'bekas'])->default('baru');
            $table->enum('status', ['tersedia', 'habis', 'tidak_aktif'])->default('tersedia');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('smartphones');
    }
};
