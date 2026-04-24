@extends('layouts.app')

@section('title', $smartphone->nama_produk)

@section('content')

    <div style="margin-bottom:18px; display:flex; gap:10px;">
        <a href="{{ route('smartphones.index') }}" class="btn-outline">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('smartphones.edit', $smartphone) }}" class="btn-blue">
            <i class="bi bi-pencil"></i> Edit Produk
        </a>
    </div>

    <h1 class="page-heading">🔍 Detail Produk</h1>

    <div class="row g-4">

        {{-- KIRI: Info Produk --}}
        <div class="col-lg-8">
            <div class="card-box">
                <div class="card-head">
                    <h2>
                        <i class="bi bi-phone" style="color:#2563eb;"></i>
                        {{ $smartphone->nama_produk }}
                    </h2>
                    <div style="display:flex; gap:6px;">
                        @php
                            $statusClass =
                                ['tersedia' => 'badge-green', 'habis' => 'badge-yellow', 'tidak_aktif' => 'badge-gray'][
                                    $smartphone->status
                                ] ?? 'badge-gray';
                            $statusLabel =
                                ['tersedia' => 'Tersedia', 'habis' => 'Stok Habis', 'tidak_aktif' => 'Tidak Aktif'][
                                    $smartphone->status
                                ] ?? $smartphone->status;
                        @endphp
                        <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                        <span class="{{ $smartphone->kondisi == 'baru' ? 'badge-blue' : 'badge-gray' }}">
                            {{ ucfirst($smartphone->kondisi) }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Gambar --}}
                    @if ($smartphone->gambar)
                        <img src="{{ asset('storage/' . $smartphone->gambar) }}" alt="{{ $smartphone->nama_produk }}"
                            style="width:100%; max-height:260px; object-fit:cover; border-radius:10px;
                                margin-bottom:20px; border:1.5px solid #e8e8e8;">
                    @endif

                    {{-- Info Dasar --}}
                    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px;">
                        <span
                            style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:8px;
                                 padding:6px 12px; font-size:0.82rem; color:#555;">
                            <i class="bi bi-tag me-1" style="color:#2563eb;"></i>{{ $smartphone->merek }}
                        </span>
                        <span
                            style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:8px;
                                 padding:6px 12px; font-size:0.82rem; color:#555;">
                            <i class="bi bi-upc me-1" style="color:#2563eb;"></i>{{ $smartphone->model }}
                        </span>
                    </div>

                    {{-- Spesifikasi --}}
                    @if ($smartphone->spesifikasi)
                        <div style="margin-bottom:20px;">
                            <div
                                style="font-size:0.78rem; font-weight:700; text-transform:uppercase;
                                letter-spacing:0.08em; color:#aaa; margin-bottom:8px;">
                                Deskripsi</div>
                            <p style="color:#555; line-height:1.7; font-size:0.9rem; margin:0;">
                                {{ $smartphone->spesifikasi }}</p>
                        </div>
                    @endif

                    {{-- Spek Grid --}}
                    <div class="row g-3">
                        @if ($smartphone->ram)
                            <div class="col-6 col-md-3">
                                <div
                                    style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:10px;
                                    padding:14px; text-align:center;">
                                    <i class="bi bi-memory"
                                        style="font-size:1.2rem; color:#2563eb; display:block; margin-bottom:5px;"></i>
                                    <div style="font-weight:700; color:#1e293b; font-size:0.9rem;">{{ $smartphone->ram }}
                                    </div>
                                    <div style="font-size:0.72rem; color:#aaa;">RAM</div>
                                </div>
                            </div>
                        @endif
                        @if ($smartphone->kapasitas_storage)
                            <div class="col-6 col-md-3">
                                <div
                                    style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:10px;
                                    padding:14px; text-align:center;">
                                    <i class="bi bi-hdd"
                                        style="font-size:1.2rem; color:#2563eb; display:block; margin-bottom:5px;"></i>
                                    <div style="font-weight:700; color:#1e293b; font-size:0.9rem;">
                                        {{ $smartphone->kapasitas_storage }}</div>
                                    <div style="font-size:0.72rem; color:#aaa;">Storage</div>
                                </div>
                            </div>
                        @endif
                        @if ($smartphone->warna)
                            <div class="col-6 col-md-3">
                                <div
                                    style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:10px;
                                    padding:14px; text-align:center;">
                                    <i class="bi bi-palette"
                                        style="font-size:1.2rem; color:#2563eb; display:block; margin-bottom:5px;"></i>
                                    <div style="font-weight:700; color:#1e293b; font-size:0.9rem;">{{ $smartphone->warna }}
                                    </div>
                                    <div style="font-size:0.72rem; color:#aaa;">Warna</div>
                                </div>
                            </div>
                        @endif
                        <div class="col-6 col-md-3">
                            <div
                                style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:10px;
                                    padding:14px; text-align:center;">
                                <i class="bi bi-box-seam"
                                    style="font-size:1.2rem; color:#2563eb; display:block; margin-bottom:5px;"></i>
                                <div
                                    style="font-weight:700; font-size:1rem;
                                        color:{{ $smartphone->stok == 0 ? '#ef4444' : '#16a34a' }};">
                                    {{ $smartphone->stok }}
                                </div>
                                <div style="font-size:0.72rem; color:#aaa;">Unit Stok</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: Harga & Info --}}
        <div class="col-lg-4">

            {{-- Harga --}}
            <div class="card-box" style="margin-bottom:16px;">
                <div class="card-head">
                    <h2><i class="bi bi-cash-coin" style="color:#16a34a;"></i> Informasi Harga</h2>
                </div>
                <div class="card-body">
                    <div style="margin-bottom:14px;">
                        <div style="font-size:0.78rem; color:#aaa; margin-bottom:3px;">Harga Beli</div>
                        <div style="font-size:1.15rem; font-weight:700; color:#555;">{{ $smartphone->harga_beli_format }}
                        </div>
                    </div>
                    <div style="margin-bottom:14px;">
                        <div style="font-size:0.78rem; color:#aaa; margin-bottom:3px;">Harga Jual</div>
                        <div style="font-size:1.5rem; font-weight:800; color:#1e293b;">{{ $smartphone->harga_jual_format }}
                        </div>
                    </div>
                    <div style="background:#f0fdf4; border:1.5px solid #86efac; border-radius:8px; padding:12px;">
                        <div style="font-size:0.78rem; color:#16a34a; margin-bottom:2px;">Margin Keuntungan</div>
                        <div style="font-size:1.1rem; font-weight:700; color:#15803d;">
                            Rp {{ number_format($smartphone->margin, 0, ',', '.') }}
                        </div>
                        <div style="font-size:0.75rem; color:#86efac;">
                            {{ number_format(($smartphone->margin / $smartphone->harga_beli) * 100, 1) }}% dari harga beli
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Sistem --}}
            <div class="card-box">
                <div class="card-head">
                    <h2><i class="bi bi-info-circle" style="color:#2563eb;"></i> Info Sistem</h2>
                </div>
                <div class="card-body">
                    <table style="width:100%; font-size:0.85rem; border-collapse:collapse;">
                        <tr>
                            <td style="color:#aaa; padding:6px 0;">Dibuat oleh</td>
                            <td style="font-weight:600; color:#333; text-align:right;">
                                {{ $smartphone->creator->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="color:#aaa; padding:6px 0;">Tanggal dibuat</td>
                            <td style="color:#555; text-align:right;">{{ $smartphone->created_at->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td style="color:#aaa; padding:6px 0;">Diperbarui</td>
                            <td style="color:#555; text-align:right;">{{ $smartphone->updated_at->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td style="color:#aaa; padding:6px 0;">ID Produk</td>
                            <td style="color:#bbb; font-size:0.78rem; text-align:right;">
                                #{{ str_pad($smartphone->id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                    </table>

                    <div style="margin-top:16px; display:flex; flex-direction:column; gap:8px;">
                        <a href="{{ route('smartphones.edit', $smartphone) }}" class="btn-blue"
                            style="justify-content:center; padding:10px;">
                            <i class="bi bi-pencil"></i> Edit Produk
                        </a>
                        <form method="POST" action="{{ route('smartphones.destroy', $smartphone) }}"
                            onsubmit="return confirm('Hapus produk ini secara permanen?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-red" style="width:100%; padding:9px; border-radius:8px;">
                                <i class="bi bi-trash me-1"></i> Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
