<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // Mengambil semua data barang
    public function index()
    {
        return response()->json(Barang::all(), 200);
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        // Auto-uppercase & auto-prefix jika user menginput tanpa COMP-
        if ($request->has('kode_barang') && !str_starts_with(strtoupper($request->kode_barang), 'COMP-')) {
            $request->merge(['kode_barang' => 'COMP-' . ltrim(strtoupper($request->kode_barang), '-')]);
        }

        $request->validate([
            'kode_barang' => 'required|string|max:50|regex:/^COMP-[A-Za-z0-9_-]+$/i|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|min:3|max:255|unique:barangs,nama_barang',
            'kategori'    => 'nullable|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable',
            'gambar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ], [
            'kode_barang.regex'  => "Kode barang wajib menggunakan prefix 'COMP-' (contoh: COMP-001)",
            'kode_barang.unique' => 'Kode barang sudah digunakan!',
            'nama_barang.min'    => 'Nama barang minimal 3 karakter!',
            'nama_barang.unique' => 'Nama barang sudah ada di sistem!',
            'harga.min'          => 'Harga barang tidak boleh bernilai negatif!',
            'stok.min'           => 'Stok barang tidak boleh bernilai negatif!',
        ]);

        $gambarPath = $request->gambar;

        if ($request->hasFile('gambar_file')) {
            $gambarPath = $request->file('gambar_file')->store('barangs', 'public');
        }

        $barang = Barang::create([
            'kode_barang' => strtoupper($request->kode_barang),
            'nama_barang' => trim($request->nama_barang),
            'kategori'    => $request->input('kategori', 'Komputer'),
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'gambar'      => $gambarPath,
        ]);

        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = Barang::find($id);
        if ($barang) {
            return response()->json($barang, 200);
        }
        return response()->json(['message' => 'Barang tidak ditemukan'], 404);
    }

    // Mengedit data barang
    public function update(Request $request, $id)
    {
        if ($request->has('kode_barang') && !str_starts_with(strtoupper($request->kode_barang), 'COMP-')) {
            $request->merge(['kode_barang' => 'COMP-' . ltrim(strtoupper($request->kode_barang), '-')]);
        }

        $request->validate([
            'kode_barang' => 'required|string|max:50|regex:/^COMP-[A-Za-z0-9_-]+$/i|unique:barangs,kode_barang,' . $id,
            'nama_barang' => 'required|string|min:3|max:255|unique:barangs,nama_barang,' . $id,
            'kategori'    => 'nullable|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable',
            'gambar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ], [
            'kode_barang.regex'  => "Kode barang wajib menggunakan prefix 'COMP-' (contoh: COMP-001)",
            'kode_barang.unique' => 'Kode barang sudah digunakan!',
            'nama_barang.min'    => 'Nama barang minimal 3 karakter!',
            'nama_barang.unique' => 'Nama barang sudah ada di sistem!',
        ]);

        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $gambarPath = $barang->gambar;

        if ($request->hasFile('gambar_file')) {
            // Hapus gambar lama jika merupakan file lokal di storage
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $gambarPath = $request->file('gambar_file')->store('barangs', 'public');
        } elseif ($request->has('gambar')) {
            $inputGambar = $request->input('gambar');
            if (empty($inputGambar)) {
                // User menghapus gambar: hapus file lama di storage & set NULL
                if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                    Storage::disk('public')->delete($barang->gambar);
                }
                $gambarPath = null;
            } else {
                $gambarPath = $inputGambar;
            }
        }

        $barang->update([
            'kode_barang' => strtoupper($request->kode_barang),
            'nama_barang' => trim($request->nama_barang),
            'kategori'    => $request->input('kategori', $barang->kategori ?? 'Komputer'),
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'gambar'      => $gambarPath,
        ]);

        return response()->json($barang, 200);
    }

    // Menghapus data barang
    public function destroy($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        // Aturan Bisnis: Barang hanya boleh dihapus jika stok = 0
        if ($barang->stok > 0) {
            return response()->json([
                'status'  => 'error',
                'message' => "Tidak dapat menghapus '{$barang->nama_barang}'! Stok masih tersisa {$barang->stok} unit. Nol-kan stok terlebih dahulu."
            ], 400);
        }

        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Barang berhasil dihapus'
        ], 200);
    }
}
