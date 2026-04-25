@extends('layouts.app')

@section('title', $transaksi->kode_transaksi)

@section('content')

    <div style="margin-bottom:18px; display:flex; gap:10px;">
        <a href="{{ route('transaksi.index') }}" class="btn-outline">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn-blue">
            <i class="bi bi-pencil"></i> Edit Transaksi
        </a>
    </div>

    <h1 class="page-heading">🔍 Detail Transaksi</h1>

    <div class="row g-4">

        {{-- KIRI: Info Utama --}}
        <div class="col-lg-8">
            <div class="card-box">
                <div class="card-head">
                    <h2>
                        <i class="bi bi-receipt" style="color:#2563eb;"></i>
                        <span style="font-family:monospace;">{{ $transaksi->kode_transaksi }}</span>
                    </h2>
                    <div style="display:flex; gap:6px;">
                        @php
                            $statusInfo = [
                                'selesai' => ['Selesai', 'badge-green'],
                                'pending' => ['Pending', 'badge-yellow'],
                                'dibatalkan' => ['Dibatalkan', 'badge-gray'],
                            ][$transaksi->status_transaksi] ?? [$transaksi->status_transaksi, 'badge-gray'];
                        @endphp
                        <span class="{{ $statusInfo[1] }}">{{ $statusInfo[0] }}</span>
                    </div>
                </div>
                <div class="card-body">

                    {{-- Produk --}}
                    <div
                        style="margin-bottom:20px; padding:14px; background:#f8f9fb;
                                border:1.5px solid #e8e8e8; border-radius:10px;">
                        <div
                            style="font-size:0.72rem; font-weight:700; text-transform:uppercase;
                            letter-spacing:0.08em; color:#aaa; margin-bottom:6px;">
                            Produk Terjual</div>
                        @if ($transaksi->smartphone)
                            <div style="font-size:1.05rem; font-weight:800; color:#1e293b;">
                                {{ $transaksi->smartphone->nama_produk }}
                            </div>
                            <div style="font-size:0.82rem; color:#999; margin-top:3px;">
                                {{ $transaksi->smartphone->merek }} · {{ $transaksi->smartphone->model }}
                                @if ($transaksi->smartphone->ram)
                                    · {{ $transaksi->smartphone->ram }}
                                @endif
                                @if ($transaksi->smartphone->kapasitas_storage)
                                    / {{ $transaksi->smartphone->kapasitas_storage }}
                                @endif
                            </div>
                        @else
                            <span style="color:#aaa;">Produk tidak ditemukan</span>
                        @endif
                    </div>

                    {{-- Grid Info --}}
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div
                                style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:10px;
                                padding:14px; text-align:center;">
                                <i class="bi bi-boxes"
                                    style="font-size:1.2rem; color:#2563eb; display:block; margin-bottom:5px;"></i>
                                <div style="font-weight:800; color:#1e293b; font-size:1.1rem;">{{ $transaksi->jumlah }}
                                </div>
                                <div style="font-size:0.72rem; color:#aaa;">Unit</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div
                                style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:10px;
                                padding:14px; text-align:center;">
                                <i class="bi bi-tag"
                                    style="font-size:1.2rem; color:#2563eb; display:block; margin-bottom:5px;"></i>
                                <div style="font-weight:700; color:#1e293b; font-size:0.85rem;">
                                    {{ $transaksi->harga_satuan_format }}</div>
                                <div style="font-size:0.72rem; color:#aaa;">Harga / Unit</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div
                                style="background:#f0fdf4; border:1.5px solid #86efac; border-radius:10px;
                                padding:14px; text-align:center;">
                                <i class="bi bi-cash-coin"
                                    style="font-size:1.2rem; color:#16a34a; display:block; margin-bottom:5px;"></i>
                                <div style="font-weight:800; color:#15803d; font-size:0.85rem;">
                                    {{ $transaksi->total_harga_format }}</div>
                                <div style="font-size:0.72rem; color:#86efac;">Total</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            @php
                                $metodeLabel = [
                                    'tunai' => ['Tunai', 'badge-green', 'bi-cash'],
                                    'transfer' => ['Transfer', 'badge-blue', 'bi-bank'],
                                    'kartu_kredit' => ['Kartu Kredit', 'badge-orange', 'bi-credit-card'],
                                    'qris' => ['QRIS', 'badge-gray', 'bi-qr-code'],
                                ][$transaksi->metode_pembayaran] ?? [
                                    $transaksi->metode_pembayaran,
                                    'badge-gray',
                                    'bi-cash',
                                ];
                            @endphp
                            <div
                                style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:10px;
                                padding:14px; text-align:center;">
                                <i class="bi {{ $metodeLabel[2] }}"
                                    style="font-size:1.2rem; color:#2563eb; display:block; margin-bottom:5px;"></i>
                                <div style="font-size:0.82rem; font-weight:700; color:#1e293b;">{{ $metodeLabel[0] }}</div>
                                <div style="font-size:0.72rem; color:#aaa;">Pembayaran</div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Pembeli --}}
                    <div style="margin-top:20px;">
                        <div
                            style="font-size:0.78rem; font-weight:700; text-transform:uppercase;
                            letter-spacing:0.08em; color:#aaa; margin-bottom:8px;">
                            Data Pembeli</div>
                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                            <span
                                style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:8px;
                                 padding:6px 12px; font-size:0.88rem; color:#333; font-weight:600;">
                                <i class="bi bi-person me-1" style="color:#2563eb;"></i>{{ $transaksi->nama_pembeli }}
                            </span>
                            @if ($transaksi->no_telp_pembeli)
                                <span
                                    style="background:#f8f9fb; border:1.5px solid #e8e8e8; border-radius:8px;
                                     padding:6px 12px; font-size:0.88rem; color:#555;">
                                    <i class="bi bi-telephone me-1"
                                        style="color:#2563eb;"></i>{{ $transaksi->no_telp_pembeli }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Catatan --}}
                    @if ($transaksi->catatan)
                        <div style="margin-top:16px;">
                            <div
                                style="font-size:0.78rem; font-weight:700; text-transform:uppercase;
                                letter-spacing:0.08em; color:#aaa; margin-bottom:6px;">
                                Catatan</div>
                            <p
                                style="color:#555; line-height:1.7; font-size:0.9rem; margin:0;
                                background:#fffbeb; border:1.5px solid #fde68a; border-radius:8px;
                                padding:12px;">
                                {{ $transaksi->catatan }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- KANAN: Info Sistem --}}
        <div class="col-lg-4">
            <div class="card-box">
                <div class="card-head">
                    <h2><i class="bi bi-info-circle" style="color:#2563eb;"></i> Info Sistem</h2>
                </div>
                <div class="card-body">
                    <table style="width:100%; font-size:0.85rem; border-collapse:collapse;">
                        <tr>
                            <td style="color:#aaa; padding:7px 0;">Dicatat oleh</td>
                            <td style="font-weight:600; color:#333; text-align:right;">
                                {{ $transaksi->user->name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="color:#aaa; padding:7px 0;">Tanggal Transaksi</td>
                            <td style="color:#555; text-align:right;">
                                {{ $transaksi->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="color:#aaa; padding:7px 0;">Terakhir Diubah</td>
                            <td style="color:#555; text-align:right;">
                                {{ $transaksi->updated_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="color:#aaa; padding:7px 0;">ID</td>
                            <td style="color:#bbb; font-size:0.78rem; text-align:right;">
                                #{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:16px; display:flex; flex-direction:column; gap:8px;">
                        <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn-blue"
                            style="justify-content:center; padding:10px;">
                            <i class="bi bi-pencil"></i> Edit Transaksi
                        </a>
                        @if ($transaksi->status_transaksi !== 'selesai')
                            <form method="POST" action="{{ route('transaksi.destroy', $transaksi) }}"
                                onsubmit="return confirm('Hapus transaksi ini secara permanen?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-red" style="width:100%; padding:9px; border-radius:8px;">
                                    <i class="bi bi-trash me-1"></i> Hapus Transaksi
                                </button>
                            </form>
                        @else
                            <div
                                style="background:#fef9c3; border:1.5px solid #fde68a; border-radius:8px;
                                padding:10px 12px; font-size:0.8rem; color:#854d0e; text-align:center;">
                                <i class="bi bi-lock me-1"></i>
                                Transaksi selesai tidak dapat dihapus
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
