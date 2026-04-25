@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('content')

    <h1 class="page-heading">🧾 Transaksi Penjualan</h1>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="stat-icon" style="background:#eff6ff; color:#2563eb;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Transaksi</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['selesai'] }}</div>
                    <div class="stat-label">Selesai</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="stat-icon" style="background:#fef9c3; color:#ca8a04;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div>
                    <div class="stat-value" style="font-size:1rem;">
                        Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}
                    </div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card-box">
        <div class="card-head">
            <h2><i class="bi bi-receipt" style="color:#2563eb;"></i> Daftar Transaksi</h2>
            <a href="{{ route('transaksi.create') }}" class="btn-blue">
                <i class="bi bi-plus-lg"></i> Catat Transaksi
            </a>
        </div>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('transaksi.index') }}"
            style="padding:14px 20px; border-bottom:1.5px solid #e8e8e8; display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
            <div class="search-wrap" style="flex:1; min-width:180px;">
                <i class="bi bi-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="form-input"
                    placeholder="Cari kode, pembeli, produk...">
            </div>
            <select name="status" class="form-select" style="width:auto; min-width:140px;">
                <option value="">Semua Status</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <select name="metode" class="form-select" style="width:auto; min-width:150px;">
                <option value="">Semua Metode</option>
                <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="transfer" {{ request('metode') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="kartu_kredit" {{ request('metode') == 'kartu_kredit' ? 'selected' : '' }}>Kartu Kredit
                </option>
                <option value="qris" {{ request('metode') == 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
            <button type="submit" class="btn-blue" style="padding:8px 14px;">
                <i class="bi bi-funnel"></i> Cari
            </button>
            @if (request()->hasAny(['search', 'status', 'metode']))
                <a href="{{ route('transaksi.index') }}" class="btn-outline">
                    <i class="bi bi-x"></i> Reset
                </a>
            @endif
        </form>

        {{-- TABLE --}}
        <div style="overflow-x:auto;">
            <table class="simple-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Transaksi</th>
                        <th>Produk</th>
                        <th>Pembeli</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $i => $t)
                        <tr>
                            <td style="color:#aaa; font-size:0.8rem;">
                                {{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $i + 1 }}
                            </td>
                            <td>
                                <span style="font-family:monospace; font-weight:700; color:#2563eb; font-size:0.82rem;">
                                    {{ $t->kode_transaksi }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight:700; color:#1e293b; font-size:0.88rem;">
                                    {{ $t->smartphone->nama_produk ?? '-' }}
                                </div>
                                <div style="font-size:0.75rem; color:#999;">
                                    {{ $t->smartphone->merek ?? '' }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:600; color:#333;">{{ $t->nama_pembeli }}</div>
                                @if ($t->no_telp_pembeli)
                                    <div style="font-size:0.76rem; color:#999;">{{ $t->no_telp_pembeli }}</div>
                                @endif
                            </td>
                            <td style="font-weight:700; color:#1e293b; text-align:center;">
                                {{ $t->jumlah }} <span style="color:#aaa; font-size:0.78rem;">unit</span>
                            </td>
                            <td>
                                <div style="font-weight:700; color:#1e293b;">{{ $t->total_harga_format }}</div>
                                <div style="font-size:0.74rem; color:#aaa;">@ {{ $t->harga_satuan_format }}</div>
                            </td>
                            <td>
                                @php
                                    $metodeLabel = [
                                        'tunai' => ['Tunai', 'badge-green'],
                                        'transfer' => ['Transfer', 'badge-blue'],
                                        'kartu_kredit' => ['Kartu Kredit', 'badge-orange'],
                                        'qris' => ['QRIS', 'badge-gray'],
                                    ][$t->metode_pembayaran] ?? [$t->metode_pembayaran, 'badge-gray'];
                                @endphp
                                <span class="{{ $metodeLabel[1] }}">{{ $metodeLabel[0] }}</span>
                            </td>
                            <td>
                                @php
                                    $statusInfo = [
                                        'selesai' => ['Selesai', 'badge-green'],
                                        'pending' => ['Pending', 'badge-yellow'],
                                        'dibatalkan' => ['Dibatalkan', 'badge-gray'],
                                    ][$t->status_transaksi] ?? [$t->status_transaksi, 'badge-gray'];
                                @endphp
                                <span class="{{ $statusInfo[1] }}">{{ $statusInfo[0] }}</span>
                            </td>
                            <td style="font-size:0.8rem; color:#888;">
                                {{ $t->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <div style="display:flex; gap:6px; justify-content:flex-end;">
                                    <a href="{{ route('transaksi.show', $t) }}" class="btn-outline" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('transaksi.edit', $t) }}" class="btn-outline" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if ($t->status_transaksi !== 'selesai')
                                        <form method="POST" action="{{ route('transaksi.destroy', $t) }}"
                                            onsubmit="return confirm('Hapus transaksi \'{{ $t->kode_transaksi }}\'?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-red" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn-red" disabled title="Transaksi selesai tidak bisa dihapus"
                                            style="opacity:0.35; cursor:not-allowed;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align:center; padding:48px; color:#bbb;">
                                <i class="bi bi-receipt" style="font-size:2rem; display:block; margin-bottom:10px;"></i>
                                Belum ada transaksi.
                                <a href="{{ route('transaksi.create') }}"
                                    style="color:#2563eb; display:block; margin-top:8px; font-size:0.9rem;">
                                    + Catat transaksi pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($transaksis->hasPages())
            <div
                style="padding:14px 20px; border-top:1.5px solid #e8e8e8; display:flex; align-items:center;
                        justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <div style="font-size:0.82rem; color:#aaa;">
                    Menampilkan {{ $transaksis->firstItem() }}–{{ $transaksis->lastItem() }}
                    dari {{ $transaksis->total() }} transaksi
                </div>
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>

@endsection
