<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiRuangan;

class LokasiRuanganController extends Controller
{
    public function index()
    {
        $daftarLokasi = LokasiRuangan::all();
        return view('lokasi-ruangan.index', compact('daftarLokasi'));
    }

    public function simpan(Request $permintaan)
    {
        $validasi = $permintaan->validate([
            'nama_lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama_lokasi.required' => 'Nama lokasi ruangan wajib diisi.',
        ]);

        LokasiRuangan::create($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Lokasi ruangan berhasil ditambahkan.']);
        }
        return redirect()->route('lokasi-ruangan.index')->with('sukses', 'Lokasi ruangan berhasil ditambahkan.');
    }

    public function ubah(Request $permintaan, $id)
    {
        $lokasi = LokasiRuangan::findOrFail($id);

        $validasi = $permintaan->validate([
            'nama_lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama_lokasi.required' => 'Nama lokasi ruangan wajib diisi.',
        ]);

        $lokasi->update($validasi);

        if ($permintaan->ajax()) {
            return response()->json(['success' => true, 'message' => 'Lokasi ruangan berhasil diperbarui.']);
        }
        return redirect()->route('lokasi-ruangan.index')->with('sukses', 'Lokasi ruangan berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $lokasi = LokasiRuangan::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('lokasi-ruangan.index')->with('sukses', 'Lokasi ruangan berhasil dihapus.');
    }
}
