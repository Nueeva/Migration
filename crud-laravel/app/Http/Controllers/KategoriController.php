<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Http\Request;
use Exception;

class KategoriController extends Controller
{
    public function index()
    {
        // Auto-seed any unique category in barangs table that is not yet in kategoris
        $existingBarangCategories = Barang::whereNotNull('kategori')->distinct()->pluck('kategori');
        foreach ($existingBarangCategories as $catName) {
            if ($catName && !Kategori::where('nama', $catName)->exists()) {
                Kategori::create(['nama' => trim($catName), 'icon' => '📦']);
            }
        }

        $kategoris = Kategori::orderBy('nama', 'asc')->get();

        // Attach item_count to each category
        $result = $kategoris->map(function ($k) {
            $count = Barang::where('kategori', $k->nama)->count();
            return [
                'id'         => $k->id,
                'nama'       => $k->nama,
                'icon'       => $k->icon ?: '📦',
                'item_count' => $count,
                'created_at' => $k->created_at,
            ];
        });

        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|min:2|max:100|unique:kategoris,nama',
            'icon' => 'nullable|string|max:10',
        ], [
            'nama.required' => 'Nama kategori wajib diisi!',
            'nama.unique'   => 'Kategori ini sudah terdaftar!',
            'nama.min'      => 'Nama kategori minimal 2 karakter!',
        ]);

        $kategori = Kategori::create([
            'nama' => trim($request->nama),
            'icon' => $request->input('icon', '📦'),
        ]);

        return response()->json($kategori, 201);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'required|string|min:2|max:100|unique:kategoris,nama,' . $id,
            'icon' => 'nullable|string|max:10',
        ], [
            'nama.required' => 'Nama kategori wajib diisi!',
            'nama.unique'   => 'Kategori ini sudah terdaftar!',
        ]);

        $oldNama = $kategori->nama;
        $newNama = trim($request->nama);

        $kategori->update([
            'nama' => $newNama,
            'icon' => $request->input('icon', $kategori->icon ?: '📦'),
        ]);

        // Sync existing products to the updated category name
        if ($oldNama !== $newNama) {
            Barang::where('kategori', $oldNama)->update(['kategori' => $newNama]);
        }

        return response()->json($kategori, 200);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $itemCount = Barang::where('kategori', $kategori->nama)->count();
        if ($itemCount > 0) {
            return response()->json([
                'status'  => 'error',
                'message' => "Kategori '{$kategori->nama}' tidak dapat dihapus karena masih digunakan oleh {$itemCount} barang! Ubah kategori barang tersebut terlebih dahulu."
            ], 400);
        }

        $kategori->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Kategori berhasil dihapus'
        ], 200);
    }
}
