<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'smartphone_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'nama_pembeli',
        'no_telp_pembeli',
        'metode_pembayaran',
        'status_transaksi',
        'catatan',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'total_harga'  => 'decimal:2',
    ];

    // Relasi ke Smartphone
    public function smartphone()
    {
        return $this->belongsTo(Smartphone::class);
    }

    // Format harga satuan
    public function getHargaSatuanFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }

    // Format total harga
    public function getTotalHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    // Generate kode transaksi otomatis
    public static function generateKode(): string
    {
        $prefix = 'TRX-' . date('Ymd') . '-';
        $last = self::where('kode_transaksi', 'like', $prefix . '%')
                    ->orderByDesc('kode_transaksi')
                    ->value('kode_transaksi');

        $urutan = $last ? (int) substr($last, -4) + 1 : 1;
        return $prefix . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }
}
