@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')

    <div style="margin-bottom:18px;">
        <a href="{{ route('transaksi.show', $transaksi) }}" class="btn-outline">
            <i class="bi bi-arrow-left"></i> Kembali ke Detail
        </a>
    </div>

    <h1 class="page-heading">✏️ Edit Transaksi</h1>

    {{-- Info readonly produk --}}
    <div class="card-box" style="margin-bottom:16px; border-color:#dbeafe;">
        <div class="card-head" style="background:#eff6ff;">
            <h2 style="color:#1d4ed8;"><i class="bi bi-lock me-2"></i>Informasi Produk (Tidak Dapat Diubah)</h2>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label" style="color:#93c5fd;">Produk</label>
                    <input type="text" class="form-input" readonly
                        value="{{ $transaksi->smartphone->nama_produk ?? '-' }}"
                        style="background:#f0f9ff; color:#1e40af; font-weight:700;">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color:#93c5fd;">Jumlah</label>
                    <input type="text" class="form-input" readonly value="{{ $transaksi->jumlah }} unit"
                        style="background:#f0f9ff; color:#1e40af; font-weight:700;">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color:#93c5fd;">Harga / Unit</label>
                    <input type="text" class="form-input" readonly value="{{ $transaksi->harga_satuan_format }}"
                        style="background:#f0f9ff; color:#1e40af; font-weight:700;">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="color:#93c5fd;">Total Harga</label>
                    <input type="text" class="form-input" readonly value="{{ $transaksi->total_harga_format }}"
                        style="background:#f0fdf4; color:#15803d; font-weight:800;">
                </div>
            </div>
            <div style="margin-top:10px;">
                <span class="badge-blue" style="font-size:0.78rem;">
                    <i class="bi bi-upc me-1"></i>{{ $transaksi->kode_transaksi }}
                </span>
            </div>
        </div>
    </div>

    {{-- Form edit --}}
    <div class="card-box">
        <div class="card-body">
            <form method="POST" action="{{ route('transaksi.update', $transaksi) }}">
                @csrf @method('PUT')

                {{-- DATA PEMBELI --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">👤 Data Pembeli</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pembeli <span style="color:red">*</span></label>
                            <input type="text" name="nama_pembeli" class="form-input"
                                value="{{ old('nama_pembeli', $transaksi->nama_pembeli) }}" placeholder="Nama pembeli"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telp_pembeli" class="form-input"
                                value="{{ old('no_telp_pembeli', $transaksi->no_telp_pembeli) }}"
                                placeholder="cth: 08123456789">
                        </div>
                    </div>
                </div>

                {{-- PEMBAYARAN & STATUS --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">💳 Pembayaran & Status</div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Metode Pembayaran <span style="color:red">*</span></label>
                            <select name="metode_pembayaran" class="form-select" required>
                                @foreach (['tunai' => 'Tunai', 'transfer' => 'Transfer Bank', 'kartu_kredit' => 'Kartu Kredit', 'qris' => 'QRIS'] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status Transaksi <span style="color:red">*</span></label>
                            <select name="status_transaksi" class="form-select" required>
                                <option value="selesai"
                                    {{ old('status_transaksi', $transaksi->status_transaksi) == 'selesai' ? 'selected' : '' }}>
                                    Selesai</option>
                                <option value="pending"
                                    {{ old('status_transaksi', $transaksi->status_transaksi) == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="dibatalkan"
                                    {{ old('status_transaksi', $transaksi->status_transaksi) == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                            <div style="font-size:0.76rem; color:#f97316; margin-top:4px;">
                                <i class="bi bi-info-circle"></i>
                                Mengubah ke "Selesai" akan mengurangi stok. "Dibatalkan" akan mengembalikan stok.
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-textarea" placeholder="Catatan tambahan...">{{ old('catatan', $transaksi->catatan) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL --}}
                <div style="display:flex; gap:10px; padding-top:4px; border-top:1.5px solid #e8e8e8; margin-top:8px;">
                    <button type="submit" class="btn-blue" style="padding:10px 24px;">
                        <i class="bi bi-floppy"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('transaksi.show', $transaksi) }}" class="btn-outline" style="padding:10px 18px;">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
