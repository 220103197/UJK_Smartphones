<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smartphone extends Model
{
    protected $fillable = [
        'nama_produk',
        'merek',
        'model',
        'spesifikasi',
        'harga_beli',
        'harga_jual',
        'stok',
        'warna',
        'kapasitas_storage',
        'ram',
        'kondisi',
        'status',
        'gambar',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
    ];

    // Format harga
    public function getHargaJualFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }

    public function getHargaBeliFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
    }

    // Margin keuntungan
    public function getMarginAttribute(): float
    {
        return $this->harga_jual - $this->harga_beli;
    }
}