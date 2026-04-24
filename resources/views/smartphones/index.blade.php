@extends('layouts.app')

@section('title', 'Daftar Smartphone')

@section('content')

    <h1 class="page-heading">📱 Manajemen Smartphone</h1>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="stat-icon" style="background:#eff6ff; color:#2563eb;">
                    <i class="bi bi-phone"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Produk</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['tersedia'] }}</div>
                    <div class="stat-label">Tersedia</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="stat-icon" style="background:#fef9c3; color:#ca8a04;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['habis'] }}</div>
                    <div class="stat-label">Stok Habis</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="stat-icon" style="background:#f3f4f6; color:#6b7280;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="stat-value">{{ number_format($stats['stok']) }}</div>
                    <div class="stat-label">Total Unit</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card-box">
        <div class="card-head">
            <h2><i class="bi bi-phone" style="color:#2563eb;"></i> Daftar Produk</h2>
            <a href="{{ route('smartphones.create') }}" class="btn-blue">
                <i class="bi bi-plus-lg"></i> Tambah Produk
            </a>
        </div>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('smartphones.index') }}"
            style="padding:14px 20px; border-bottom:1.5px solid #e8e8e8; display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
            <div class="search-wrap" style="flex:1; min-width:180px;">
                <i class="bi bi-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="form-input"
                    placeholder="Cari nama, merek, model...">
            </div>
            <select name="merek" class="form-select" style="width:auto; min-width:130px;">
                <option value="">Semua Merek</option>
                @foreach ($mereks as $merek)
                    <option value="{{ $merek }}" {{ request('merek') == $merek ? 'selected' : '' }}>
                        {{ $merek }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select" style="width:auto; min-width:130px;">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            <button type="submit" class="btn-blue" style="padding:8px 14px;">
                <i class="bi bi-funnel"></i> Cari
            </button>
            @if (request()->hasAny(['search', 'status', 'merek']))
                <a href="{{ route('smartphones.index') }}" class="btn-outline">
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
                        <th>Produk</th>
                        <th>Spesifikasi</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Kondisi</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($smartphones as $i => $s)
                        <tr>
                            <td style="color:#aaa; font-size:0.8rem;">
                                {{ ($smartphones->currentPage() - 1) * $smartphones->perPage() + $i + 1 }}
                            </td>
                            <td>
                                <div style="font-weight:700; color:#1e293b;">{{ $s->nama_produk }}</div>
                                <div style="font-size:0.78rem; color:#999;">{{ $s->merek }} · {{ $s->model }}
                                </div>
                            </td>
                            <td style="font-size:0.82rem; color:#888;">
                                @if ($s->ram)
                                    {{ $s->ram }} RAM
                                @endif
                                @if ($s->kapasitas_storage)
                                    · {{ $s->kapasitas_storage }}
                                @endif
                                @if ($s->warna)
                                    · {{ $s->warna }}
                                @endif
                            </td>
                            <td>
                                <div style="font-weight:700; color:#1e293b;">{{ $s->harga_jual_format }}</div>
                                <div style="font-size:0.75rem; color:#aaa;">Beli: {{ $s->harga_beli_format }}</div>
                            </td>
                            <td>
                                <span
                                    style="font-weight:700; color:{{ $s->stok == 0 ? '#ef4444' : ($s->stok < 5 ? '#ca8a04' : '#16a34a') }};">
                                    {{ $s->stok }}
                                </span>
                                <span style="color:#aaa; font-size:0.8rem;"> unit</span>
                            </td>
                            <td>
                                @php
                                    $statusClass =
                                        [
                                            'tersedia' => 'badge-green',
                                            'habis' => 'badge-yellow',
                                            'tidak_aktif' => 'badge-gray',
                                        ][$s->status] ?? 'badge-gray';
                                    $statusLabel =
                                        ['tersedia' => 'Tersedia', 'habis' => 'Habis', 'tidak_aktif' => 'Tidak Aktif'][
                                            $s->status
                                        ] ?? $s->status;
                                @endphp
                                <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td>
                                <span class="{{ $s->kondisi == 'baru' ? 'badge-blue' : 'badge-gray' }}">
                                    {{ ucfirst($s->kondisi) }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex; gap:6px; justify-content:flex-end;">
                                    <a href="{{ route('smartphones.show', $s) }}" class="btn-outline" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('smartphones.edit', $s) }}" class="btn-outline" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('smartphones.destroy', $s) }}"
                                        onsubmit="return confirm('Hapus \'{{ $s->nama_produk }}\'?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-red" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:48px; color:#bbb;">
                                <i class="bi bi-inbox" style="font-size:2rem; display:block; margin-bottom:10px;"></i>
                                Belum ada produk.
                                <a href="{{ route('smartphones.create') }}"
                                    style="color:#2563eb; display:block; margin-top:8px; font-size:0.9rem;">
                                    + Tambah sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($smartphones->hasPages())
            <div
                style="padding:14px 20px; border-top:1.5px solid #e8e8e8; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <div style="font-size:0.82rem; color:#aaa;">
                    Menampilkan {{ $smartphones->firstItem() }}–{{ $smartphones->lastItem() }}
                    dari {{ $smartphones->total() }} produk
                </div>
                {{ $smartphones->links() }}
            </div>
        @endif
    </div>

@endsection
