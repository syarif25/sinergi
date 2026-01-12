<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $daftarKategori = KategoriBarang::all();
        return view('kategori-barang.index', compact('daftarKategori'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        KategoriBarang::create($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori barang berhasil ditambahkan.']);
        }
        return redirect()->route('kategori-barang.index')->with('sukses', 'Kategori barang berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $kategori = KategoriBarang::findOrFail($id);

        $validasi = $permintaan->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        $kategori->update($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori barang berhasil diperbarui.']);
        }
        return redirect()->route('kategori-barang.index')->with('sukses', 'Kategori barang berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $kategori = KategoriBarang::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori-barang.index')->with('sukses', 'Kategori barang berhasil dihapus.');
    }
}
