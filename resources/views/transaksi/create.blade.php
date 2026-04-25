@extends('layouts.app')

@section('title', 'Catat Transaksi Baru')

@section('content')

    <div style="margin-bottom:18px;">
        <a href="{{ route('transaksi.index') }}" class="btn-outline">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <h1 class="page-heading">🧾 Catat Transaksi Baru</h1>

    <div class="card-box">
        <div class="card-body">
            <form method="POST" action="{{ route('transaksi.store') }}">
                @csrf

                {{-- PILIH PRODUK --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">📱 Pilih Produk</div>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Smartphone <span style="color:red">*</span></label>
                            <select name="smartphone_id" id="smartphoneSelect" class="form-select" required
                                onchange="updateHarga(this)">
                                <option value="">-- Pilih produk tersedia --</option>
                                @foreach ($smartphones as $sp)
                                    <option value="{{ $sp->id }}" data-harga="{{ $sp->harga_jual }}"
                                        data-stok="{{ $sp->stok }}"
                                        {{ old('smartphone_id') == $sp->id ? 'selected' : '' }}>
                                        {{ $sp->nama_produk }} — {{ $sp->merek }}
                                        (Stok: {{ $sp->stok }} | Rp {{ number_format($sp->harga_jual, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Stok Tersedia</label>
                            <input type="text" id="infoStok" class="form-input" readonly
                                value="{{ old('smartphone_id') ? '' : '-' }}"
                                style="background:#f5f5f5; font-weight:700; color:#2563eb;">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Harga Satuan</label>
                            <input type="text" id="infoHarga" class="form-input" readonly
                                value="{{ old('smartphone_id') ? '' : '-' }}"
                                style="background:#f5f5f5; font-weight:700; color:#16a34a;">
                        </div>
                    </div>
                </div>

                {{-- DETAIL TRANSAKSI --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">📋 Detail Transaksi</div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Jumlah Unit <span style="color:red">*</span></label>
                            <input type="number" name="jumlah" id="jumlahInput" class="form-input"
                                value="{{ old('jumlah', 1) }}" min="1" required oninput="updateTotal()">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Total Harga</label>
                            <input type="text" id="infoTotal" class="form-input" readonly value="-"
                                style="background:#f0fdf4; font-weight:800; color:#16a34a; font-size:1rem;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Metode Pembayaran <span style="color:red">*</span></label>
                            <select name="metode_pembayaran" class="form-select" required>
                                @foreach (['tunai' => 'Tunai', 'transfer' => 'Transfer Bank', 'kartu_kredit' => 'Kartu Kredit', 'qris' => 'QRIS'] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ old('metode_pembayaran', 'tunai') == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status <span style="color:red">*</span></label>
                            <select name="status_transaksi" class="form-select" required>
                                <option value="selesai"
                                    {{ old('status_transaksi', 'selesai') == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="pending" {{ old('status_transaksi') == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="dibatalkan" {{ old('status_transaksi') == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- DATA PEMBELI --}}
                <div style="margin-bottom:28px;">
                    <div class="section-title">👤 Data Pembeli</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pembeli <span style="color:red">*</span></label>
                            <input type="text" name="nama_pembeli" class="form-input" value="{{ old('nama_pembeli') }}"
                                placeholder="cth: Budi Santoso" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telp_pembeli" class="form-input"
                                value="{{ old('no_telp_pembeli') }}" placeholder="cth: 08123456789">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-textarea" placeholder="Catatan tambahan (opsional)...">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL --}}
                <div style="display:flex; gap:10px; padding-top:4px; border-top:1.5px solid #e8e8e8; margin-top:8px;">
                    <button type="submit" class="btn-blue" style="padding:10px 24px;">
                        <i class="bi bi-floppy"></i> Simpan Transaksi
                    </button>
                    <a href="{{ route('transaksi.index') }}" class="btn-outline" style="padding:10px 18px;">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let hargaSatuan = 0;

        function formatRupiah(angka) {
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        function updateHarga(sel) {
            const opt = sel.options[sel.selectedIndex];
            if (!opt.value) {
                document.getElementById('infoStok').value = '-';
                document.getElementById('infoHarga').value = '-';
                document.getElementById('infoTotal').value = '-';
                hargaSatuan = 0;
                return;
            }
            hargaSatuan = parseFloat(opt.dataset.harga) || 0;
            const stok = opt.dataset.stok || 0;
            document.getElementById('infoStok').value = stok + ' unit';
            document.getElementById('infoHarga').value = formatRupiah(hargaSatuan);
            document.getElementById('jumlahInput').max = stok;
            updateTotal();
        }

        function updateTotal() {
            const jumlah = parseInt(document.getElementById('jumlahInput').value) || 0;
            document.getElementById('infoTotal').value = hargaSatuan > 0 ?
                formatRupiah(hargaSatuan * jumlah) :
                '-';
        }

        // Init jika ada old value
        document.addEventListener('DOMContentLoaded', () => {
            const sel = document.getElementById('smartphoneSelect');
            if (sel.value) updateHarga(sel);
        });
    </script>
@endpush
