<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Smartphone;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('smartphone')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_pembeli', 'like', "%{$search}%")
                  ->orWhereHas('smartphone', fn($s) => $s->where('nama_produk', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status_transaksi', $request->status);
        }

        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        $transaksis = $query->paginate(15)->withQueryString();

        $stats = [
            'total'      => Transaksi::count(),
            'selesai'    => Transaksi::where('status_transaksi', 'selesai')->count(),
            'pending'    => Transaksi::where('status_transaksi', 'pending')->count(),
            'pendapatan' => Transaksi::where('status_transaksi', 'selesai')->sum('total_harga'),
        ];

        return view('transaksi.index', compact('transaksis', 'stats'));
    }

    public function create()
    {
        $smartphones = Smartphone::where('status', 'tersedia')->where('stok', '>', 0)->get();
        return view('transaksi.create', compact('smartphones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'smartphone_id'     => 'required|exists:smartphones,id',
            'jumlah'            => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:tunai,transfer,kartu_kredit,qris',
            'status_transaksi'  => 'required|in:selesai,pending,dibatalkan',
            'nama_pembeli'      => 'required|string|max:255',
            'no_telp_pembeli'   => 'nullable|string|max:20',
            'catatan'           => 'nullable|string',
        ]);

        $smartphone = Smartphone::findOrFail($request->smartphone_id);

        if ($request->jumlah > $smartphone->stok) {
            return back()->withErrors(['jumlah' => 'Jumlah melebihi stok tersedia (' . $smartphone->stok . ' unit).'])->withInput();
        }

        $harga_satuan = $smartphone->harga_jual;
        $total_harga  = $harga_satuan * $request->jumlah;

        $transaksi = Transaksi::create([
            'kode_transaksi'    => Transaksi::generateKode(),
            'smartphone_id'     => $request->smartphone_id,
            'jumlah'            => $request->jumlah,
            'harga_satuan'      => $harga_satuan,
            'total_harga'       => $total_harga,
            'nama_pembeli'      => $request->nama_pembeli,
            'no_telp_pembeli'   => $request->no_telp_pembeli,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_transaksi'  => $request->status_transaksi,
            'catatan'           => $request->catatan,
        ]);

        // Kurangi stok jika transaksi selesai
        if ($request->status_transaksi === 'selesai') {
            $smartphone->decrement('stok', $request->jumlah);
            if ($smartphone->stok <= 0) {
                $smartphone->update(['status' => 'habis']);
            }
        }

        return redirect()->route('transaksi.show', $transaksi)
                         ->with('success', 'Transaksi ' . $transaksi->kode_transaksi . ' berhasil dicatat!');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('smartphone');
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $smartphones = Smartphone::where('status', 'tersedia')->orWhere('id', $transaksi->smartphone_id)->get();
        return view('transaksi.edit', compact('transaksi', 'smartphones'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:tunai,transfer,kartu_kredit,qris',
            'status_transaksi'  => 'required|in:selesai,pending,dibatalkan',
            'nama_pembeli'      => 'required|string|max:255',
            'no_telp_pembeli'   => 'nullable|string|max:20',
            'catatan'           => 'nullable|string',
        ]);

        $statusLama = $transaksi->status_transaksi;
        $statusBaru = $request->status_transaksi;

        $transaksi->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_transaksi'  => $statusBaru,
            'nama_pembeli'      => $request->nama_pembeli,
            'no_telp_pembeli'   => $request->no_telp_pembeli,
            'catatan'           => $request->catatan,
        ]);

        // Sesuaikan stok jika status berubah
        $smartphone = $transaksi->smartphone;
        if ($statusLama !== 'selesai' && $statusBaru === 'selesai') {
            $smartphone->decrement('stok', $transaksi->jumlah);
            if ($smartphone->stok <= 0) $smartphone->update(['status' => 'habis']);
        } elseif ($statusLama === 'selesai' && $statusBaru !== 'selesai') {
            $smartphone->increment('stok', $transaksi->jumlah);
            if ($smartphone->stok > 0) $smartphone->update(['status' => 'tersedia']);
        }

        return redirect()->route('transaksi.show', $transaksi)
                         ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        if ($transaksi->status_transaksi === 'selesai') {
            return back()->with('error', 'Transaksi yang sudah selesai tidak dapat dihapus.');
        }

        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
