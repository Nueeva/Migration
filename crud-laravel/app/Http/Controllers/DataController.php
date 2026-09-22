<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    // GET: Menampilkan semua data
    public function index()
    {
        $data = Data::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar data berhasil diambil',
            'data'    => $data
        ], 200);
    }

    // POST: Menyimpan data baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'     => 'required|unique:data',
            'nama'    => 'required',
            'telepon' => 'required',
            'alamat'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Data::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // GET: Menampilkan detail 1 data berdasarkan ID
    public function show($id)
    {
        $data = Data::find($id);
        
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Detail data',
                'data'    => $data
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan',
        ], 404);
    }

    // PUT/PATCH: Mengupdate data
    public function update(Request $request, $id)
    {
        $data = Data::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nik'     => 'required|unique:data,nik,'.$id,
            'nama'    => 'required',
            'telepon' => 'required',
            'alamat'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data'    => $data
        ], 200);
    }

    // DELETE: Menghapus data
    public function destroy($id)
    {
        $data = Data::find($id);

        if ($data) {
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan',
        ], 404);
    }
}