@extends('layouts.app')

@section('title', 'Edit Smartphone')

@section('content')

    <div style="margin-bottom:18px; display:flex; gap:10px;">
        <a href="{{ route('smartphones.index') }}" class="btn-outline">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('smartphones.show', $smartphone) }}" class="btn-outline">
            <i class="bi bi-eye"></i> Lihat Detail
        </a>
    </div>

    <h1 class="page-heading">✏️ Edit: {{ $smartphone->nama_produk }}</h1>

    <div class="card-box">
        <div class="card-body">
            <form method="POST" action="{{ route('smartphones.update', $smartphone) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- IDENTITAS --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">📋 Identitas Produk</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Produk <span style="color:red">*</span></label>
                            <input type="text" name="nama_produk" class="form-input"
                                value="{{ old('nama_produk', $smartphone->nama_produk) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Merek <span style="color:red">*</span></label>
                            <input type="text" name="merek" class="form-input"
                                value="{{ old('merek', $smartphone->merek) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Model <span style="color:red">*</span></label>
                            <input type="text" name="model" class="form-input"
                                value="{{ old('model', $smartphone->model) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi / Spesifikasi</label>
                            <textarea name="spesifikasi" class="form-textarea">{{ old('spesifikasi', $smartphone->spesifikasi) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SPESIFIKASI TEKNIS --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">⚙️ Spesifikasi Teknis</div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">RAM</label>
                            <input type="text" name="ram" class="form-input"
                                value="{{ old('ram', $smartphone->ram) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Storage</label>
                            <input type="text" name="kapasitas_storage" class="form-input"
                                value="{{ old('kapasitas_storage', $smartphone->kapasitas_storage) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Warna</label>
                            <input type="text" name="warna" class="form-input"
                                value="{{ old('warna', $smartphone->warna) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kondisi <span style="color:red">*</span></label>
                            <select name="kondisi" class="form-select" required>
                                <option value="baru"
                                    {{ old('kondisi', $smartphone->kondisi) == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="bekas"
                                    {{ old('kondisi', $smartphone->kondisi) == 'bekas' ? 'selected' : '' }}>Bekas</option>
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
                            <input type="number" name="harga_beli" class="form-input"
                                value="{{ old('harga_beli', $smartphone->harga_beli) }}" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga Jual (Rp) <span style="color:red">*</span></label>
                            <input type="number" name="harga_jual" class="form-input"
                                value="{{ old('harga_jual', $smartphone->harga_jual) }}" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stok <span style="color:red">*</span></label>
                            <input type="number" name="stok" class="form-input"
                                value="{{ old('stok', $smartphone->stok) }}" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status <span style="color:red">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="tersedia"
                                    {{ old('status', $smartphone->status) == 'tersedia' ? 'selected' : '' }}>Tersedia
                                </option>
                                <option value="habis"
                                    {{ old('status', $smartphone->status) == 'habis' ? 'selected' : '' }}>Habis
                                </option>
                                <option value="tidak_aktif"
                                    {{ old('status', $smartphone->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- GAMBAR --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">🖼️ Gambar Produk</div>
                    @if ($smartphone->gambar)
                        <div style="margin-bottom:10px;">
                            <img src="{{ asset('storage/' . $smartphone->gambar) }}" alt="Gambar produk"
                                style="height:80px; border-radius:8px; border:1.5px solid #e0e0e0; object-fit:cover;">
                            <div style="font-size:0.78rem; color:#aaa; margin-top:5px;">
                                Gambar saat ini. Upload baru untuk mengganti.
                            </div>
                        </div>
                    @endif
                    <input type="file" name="gambar" class="form-input" accept="image/*" style="padding:8px 12px;">
                </div>

                {{-- TOMBOL --}}
                <div style="display:flex; gap:10px; padding-top:4px; border-top:1.5px solid #e8e8e8; margin-top:8px;">
                    <button type="submit" class="btn-blue" style="padding:10px 24px;">
                        <i class="bi bi-floppy"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('smartphones.index') }}" class="btn-outline" style="padding:10px 18px;">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
