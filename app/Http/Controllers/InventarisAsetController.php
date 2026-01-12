<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventarisAset;
use App\Models\KategoriBarang;
use App\Models\LokasiRuangan;

class InventarisAsetController extends Controller
{
    public function index(Request $permintaan)
    {
        $query = InventarisAset::with(['kategori', 'lokasi']);

        // Filter Tanggal Perolehan
        if ($permintaan->filled('tanggal_awal') && $permintaan->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_perolehan', [$permintaan->tanggal_awal, $permintaan->tanggal_akhir]);
        }

        // Filter Kategori
        if ($permintaan->filled('id_kategori')) {
            $query->where('id_kategori', $permintaan->id_kategori);
        }

        // Filter Lokasi
        if ($permintaan->filled('id_lokasi')) {
            $query->where('id_lokasi', $permintaan->id_lokasi);
        }

        // Filter Kondisi
        if ($permintaan->filled('kondisi')) {
            $query->where('kondisi', $permintaan->kondisi);
        }

        $daftarAset = $query->latest()->get();
        $daftarKategori = KategoriBarang::all();
        $daftarLokasi = LokasiRuangan::all();
        
        return view('inventaris.index', compact('daftarAset', 'daftarKategori', 'daftarLokasi'));
    }

    public function simpan(Request $permintaan)
    {
        // Hapus titik dari nilai_perolehan sebelum validasi
        $permintaan->merge([
            'nilai_perolehan' => str_replace('.', '', $permintaan->nilai_perolehan)
        ]);

        $validasi = $permintaan->validate([
            'kode_aset' => 'required|string|unique:inventaris_aset,kode_aset|max:255',
            'nama_aset' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_barang,id_kategori',
            'id_lokasi' => 'required|exists:lokasi_ruangan,id_lokasi',
            'kondisi' => 'required|in:Baik,Rusak,Hilang',
            'tanggal_perolehan' => 'required|date',
            'nilai_perolehan' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        InventarisAset::create($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data aset berhasil ditambahkan.']);
        }
        return redirect()->route('inventaris.index')->with('sukses', 'Data aset berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $aset = InventarisAset::findOrFail($id);

        // Hapus titik dari nilai_perolehan sebelum validasi
        $permintaan->merge([
            'nilai_perolehan' => str_replace('.', '', $permintaan->nilai_perolehan)
        ]);

        $validasi = $permintaan->validate([
            'kode_aset' => 'required|string|max:255|unique:inventaris_aset,kode_aset,'.$id.',id_aset',
            'nama_aset' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_barang,id_kategori',
            'id_lokasi' => 'required|exists:lokasi_ruangan,id_lokasi',
            'kondisi' => 'required|in:Baik,Rusak,Hilang',
            'tanggal_perolehan' => 'required|date',
            'nilai_perolehan' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $aset->update($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data aset berhasil diperbarui.']);
        }
        return redirect()->route('inventaris.index')->with('sukses', 'Data aset berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $aset = InventarisAset::findOrFail($id);
        $aset->delete();

        return redirect()->route('inventaris.index')->with('sukses', 'Data aset berhasil dihapus.');
    }
}
