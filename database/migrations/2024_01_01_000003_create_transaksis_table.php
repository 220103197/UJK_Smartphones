<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('smartphone_id')->constrained('smartphones')->onDelete('restrict');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->string('nama_pembeli');
            $table->string('no_telp_pembeli')->nullable();
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'kartu_kredit', 'qris'])->default('tunai');
            $table->enum('status_transaksi', ['selesai', 'pending', 'dibatalkan'])->default('selesai');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
