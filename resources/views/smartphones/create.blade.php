@extends('layouts.app')

@section('title', 'Tambah Smartphone')

@section('content')

    <div style="margin-bottom:18px;">
        <a href="{{ route('smartphones.index') }}" class="btn-outline">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <h1 class="page-heading">➕ Tambah Produk Baru</h1>

    <div class="card-box">
        <div class="card-body">
            <form method="POST" action="{{ route('smartphones.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- IDENTITAS --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">📋 Identitas Produk</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Produk <span style="color:red">*</span></label>
                            <input type="text" name="nama_produk" class="form-input" value="{{ old('nama_produk') }}"
                                placeholder="cth: iPhone 15 Pro Max" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Merek <span style="color:red">*</span></label>
                            <input type="text" name="merek" class="form-input" value="{{ old('merek') }}"
                                placeholder="cth: Apple" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Model <span style="color:red">*</span></label>
                            <input type="text" name="model" class="form-input" value="{{ old('model') }}"
                                placeholder="cth: A3108" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi / Spesifikasi</label>
                            <textarea name="spesifikasi" class="form-textarea" placeholder="Tulis deskripsi atau spesifikasi lengkap...">{{ old('spesifikasi') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SPESIFIKASI TEKNIS --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">⚙️ Spesifikasi Teknis</div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">RAM</label>
                            <input type="text" name="ram" class="form-input" value="{{ old('ram') }}"
                                placeholder="cth: 8GB">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Storage</label>
                            <input type="text" name="kapasitas_storage" class="form-input"
                                value="{{ old('kapasitas_storage') }}" placeholder="cth: 256GB">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Warna</label>
                            <input type="text" name="warna" class="form-input" value="{{ old('warna') }}"
                                placeholder="cth: Space Black">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kondisi <span style="color:red">*</span></label>
                            <select name="kondisi" class="form-select" required>
                                <option value="baru" {{ old('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="bekas" {{ old('kondisi') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- HARGA & STOK --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">💰 Harga & Stok</div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Harga Beli (Rp) <span style="color:red">*</span></label>
                            <input type="number" name="harga_beli" class="form-input" value="{{ old('harga_beli') }}"
                                placeholder="0" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga Jual (Rp) <span style="color:red">*</span></label>
                            <input type="number" name="harga_jual" class="form-input" value="{{ old('harga_jual') }}"
                                placeholder="0" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stok <span style="color:red">*</span></label>
                            <input type="number" name="stok" class="form-input" value="{{ old('stok', 0) }}"
                                min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status <span style="color:red">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia
                                </option>
                                <option value="habis" {{ old('status') == 'habis' ? 'selected' : '' }}>Habis
                                </option>
                                <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak
                                    Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- GAMBAR --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">🖼️ Gambar Produk</div>
                    <label class="form-label">Upload Gambar (JPEG/PNG/WebP, maks 2MB)</label>
                    <input type="file" name="gambar" class="form-input" accept="image/*" style="padding:8px 12px;">
                </div>

                {{-- TOMBOL --}}
                <div style="display:flex; gap:10px; padding-top:4px; border-top:1.5px solid #e8e8e8; margin-top:8px;">
                    <button type="submit" class="btn-blue" style="padding:10px 24px;">
                        <i class="bi bi-floppy"></i> Simpan Produk
                    </button>
                    <a href="{{ route('smartphones.index') }}" class="btn-outline" style="padding:10px 18px;">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
