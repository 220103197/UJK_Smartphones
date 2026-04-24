<?php

namespace App\Http\Controllers;

use App\Models\Smartphone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SmartphoneController extends Controller
{
    /**
     * READ - Tampilkan semua data smartphone
     */
    public function index(Request $request)
    {
        $query = Smartphone::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('merek', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter merek
        if ($request->filled('merek')) {
            $query->where('merek', $request->merek);
        }

        $smartphones = $query->latest()->paginate(10)->withQueryString();

        // Statistik
        $stats = [
            'total'    => Smartphone::count(),
            'tersedia' => Smartphone::where('status', 'tersedia')->count(),
            'habis'    => Smartphone::where('status', 'habis')->count(),
            'stok'     => Smartphone::sum('stok'),
        ];

        $mereks = Smartphone::distinct()->pluck('merek');

        return view('smartphones.index', compact('smartphones', 'stats', 'mereks'));
    }

    /**
     * CREATE - Form
     */
    public function create()
    {
        return view('smartphones.create');
    }

    /**
     * STORE - Simpan data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk'       => 'required|string|max:255',
            'merek'             => 'required|string|max:100',
            'model'             => 'required|string|max:100',
            'spesifikasi'       => 'nullable|string',
            'harga_beli'        => 'required|numeric|min:0',
            'harga_jual'        => 'required|numeric|min:0|gte:harga_beli',
            'stok'              => 'required|integer|min:0',
            'warna'             => 'nullable|string|max:100',
            'kapasitas_storage' => 'nullable|string|max:50',
            'ram'               => 'nullable|string|max:50',
            'kondisi'           => 'required|in:baru,bekas',
            'status'            => 'required|in:tersedia,habis,tidak_aktif',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'harga_jual.gte' => 'Harga jual tidak boleh lebih rendah dari harga beli.',
        ]);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('smartphones', 'public');
        }

        Smartphone::create($validated);

        return redirect()->route('smartphones.index')
                         ->with('success', 'Smartphone berhasil ditambahkan!');
    }

    /**
     * SHOW
     */
    public function show(Smartphone $smartphone)
    {
        return view('smartphones.show', compact('smartphone'));
    }

    /**
     * EDIT
     */
    public function edit(Smartphone $smartphone)
    {
        return view('smartphones.edit', compact('smartphone'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Smartphone $smartphone)
    {
        $validated = $request->validate([
            'nama_produk'       => 'required|string|max:255',
            'merek'             => 'required|string|max:100',
            'model'             => 'required|string|max:100',
            'spesifikasi'       => 'nullable|string',
            'harga_beli'        => 'required|numeric|min:0',
            'harga_jual'        => 'required|numeric|min:0|gte:harga_beli',
            'stok'              => 'required|integer|min:0',
            'warna'             => 'nullable|string|max:100',
            'kapasitas_storage' => 'nullable|string|max:50',
            'ram'               => 'nullable|string|max:50',
            'kondisi'           => 'required|in:baru,bekas',
            'status'            => 'required|in:tersedia,habis,tidak_aktif',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            if ($smartphone->gambar) {
                Storage::disk('public')->delete($smartphone->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('smartphones', 'public');
        }

        $smartphone->update($validated);

        return redirect()->route('smartphones.index')
                         ->with('success', 'Data smartphone berhasil diperbarui!');
    }

    /**
     * DELETE
     */
    public function destroy(Smartphone $smartphone)
    {
        if ($smartphone->gambar) {
            Storage::disk('public')->delete($smartphone->gambar);
        }

        $smartphone->delete();

        return redirect()->route('smartphones.index')
                         ->with('success', 'Smartphone berhasil dihapus!');
    }
}